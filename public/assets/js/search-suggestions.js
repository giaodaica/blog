document.addEventListener('DOMContentLoaded', function() {
    // Constants and Configuration
    const CONFIG = {
        MAX_HISTORY_ITEMS: 5,
        DEBOUNCE_DELAY: 300,
        API_ENDPOINTS: {
            SEARCH: '/search',
            SUGGESTIONS: '/search/suggestions'
        }
    };

    // DOM Elements
    const elements = {
        searchInput: document.getElementById('search'),
        searchSuggestions: document.querySelector('.search-suggestions'),
        historyList: document.querySelector('.history-list'),
        clearHistoryBtn: document.querySelector('.btn-clear-history'),
        closeSuggestionsBtn: document.querySelector('.btn-close-suggestions'),
        trendingList: document.querySelector('.trending-list'),
        autocompleteResults: document.getElementById('autocomplete-results'),
        productContainer: document.querySelector('.shop-modern'),
        clearInput: document.getElementById('clearInput')
    };

    // State Management
    const state = {
        currentPage: 1,
        currentSort: 'default',
        currentKeyword: '',
        isLoading: false,
        debounceTimer: null,
        lastRequestedTerm: null
    };

    // Get search parameters from URL
    const urlParams = new URLSearchParams(window.location.search);
    const searchQuery = urlParams.get('q');
    const searchPage = urlParams.get('page') || 1;
    const searchSort = urlParams.get('sort') || 'default';

    // Initialize state from URL parameters if they exist
    if (searchQuery) {
        state.currentKeyword = searchQuery;
        state.currentPage = parseInt(searchPage);
        state.currentSort = searchSort;
    }

    // Trending searches (should be fetched from API in production)
    const trendingSearches = [
        "Áo thun nam", "Quần jean nữ", "Váy liền thân", "Giày thể thao", 
        "Túi xách", "Đồng hồ", "Kính mát", "Phụ kiện"
    ];

    // Initialize loading overlay
    const loadingOverlay = (() => {
        const overlay = document.createElement('div');
        overlay.className = 'loading-overlay';
        overlay.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
        document.body.appendChild(overlay);
        return overlay;
    })();

    // Utility Functions
    const utils = {
        debounce(func, wait) {
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(state.debounceTimer);
                    func(...args);
                };
                clearTimeout(state.debounceTimer);
                state.debounceTimer = setTimeout(later, wait);
            };
        },

        updateURL(params) {
            const currentPath = window.location.pathname;
            const searchParams = new URLSearchParams(window.location.search);
        
            // Cập nhật các tham số tìm kiếm
            Object.entries(params).forEach(([key, value]) => {
                if (value) {
                    searchParams.set(key, value);
                } else {
                    searchParams.delete(key);
                }
            });
        
            const newURL = `/shop?${searchParams.toString()}`;
        
            // Nếu KHÔNG PHẢI đang ở trang /shop thì chuyển hướng
            if (!currentPath.startsWith('/shop')) {
                window.location.href = newURL;
            } else {
                // Nếu đang ở /shop thì cập nhật URL + gọi AJAX nếu có
                history.pushState(null, null, newURL);
                if (typeof fetchSearchResults === 'function') {
                    const query = searchParams.get('q') || '';
                    fetchSearchResults(query); // Gọi AJAX cập nhật kết quả
                }
            }
        },
        

        showLoading() {
            loadingOverlay.style.display = 'flex';
            state.isLoading = true;
        },

        hideLoading() {
            loadingOverlay.style.display = 'none';
            state.isLoading = false;
        },

        handleError(error, container) {
            console.error('Search error:', error);
            if (container) {
                container.innerHTML = `
                    <div class="col-12 text-center">
                        <p class="text-danger">Có lỗi xảy ra khi tìm kiếm. Vui lòng thử lại sau.</p>
                    </div>
                `;
            }
        }
    };

    // Search History Management
    const searchHistory = {
        get() {
            const history = localStorage.getItem('searchHistory');
            return history ? JSON.parse(history) : [];
        },

        save(keyword) {
            let history = this.get();
            history = history.filter(item => item !== keyword);
            history.unshift(keyword);
            if (history.length > CONFIG.MAX_HISTORY_ITEMS) {
                history = history.slice(0, CONFIG.MAX_HISTORY_ITEMS);
            }
            localStorage.setItem('searchHistory', JSON.stringify(history));
            this.updateUI();
        },

        remove(keyword) {
            let history = this.get();
            history = history.filter(item => item !== keyword);
            localStorage.setItem('searchHistory', JSON.stringify(history));
            this.updateUI();
        },

        clear() {
            localStorage.removeItem('searchHistory');
            this.updateUI();
        },

        updateUI() {
            if (elements.historyList) {
                this.display();
            }
            if (elements.clearHistoryBtn) {
                this.updateClearButton();
            }
        },

        display() {
            const history = this.get();
            let historyHtml = '';
            
            if (history.length > 0) {
                historyHtml = history.map(keyword => `
                    <div class="history-item p-2 border-bottom d-flex justify-content-between align-items-center" style="cursor: pointer;">
                        <div class="d-flex align-items-center text-content">
                            <i class="fa fa-history"></i>
                            <span class="ms-2" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">${keyword}</span>
                            
                        </div>
                        <button class="remove-history-item btn btn-sm btn-link p-0" data-keyword="${keyword}" style="line-height: 1;">&times;</button>
                    </div>
                `).join('');
            } else {
                historyHtml = '<div class="p-2 fw-bold text-dark" style="font-size: 16px;">Chưa có lịch sử tìm kiếm</div>';
            }
            return historyHtml;
        },

        updateClearButton() {
            // The clear button is now dynamically rendered within showSuggestions
        }
    };

    // Search Functionality
    const search = {
        async perform(keyword, page = 1, sort = 'default') {
            if (state.isLoading) return;

            searchHistory.save(keyword);
            localStorage.setItem('currentSearch', keyword);
            utils.showLoading();

            try {
                // Log for debugging
                console.log('Performing search:', {
                    keyword,
                    page,
                    sort
                });

                const url = `${CONFIG.API_ENDPOINTS.SEARCH}?q=${encodeURIComponent(keyword)}&page=${page}&sort=${sort}&t=${Date.now()}`;
                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();
                if (!data.html) {
                    throw new Error('Empty HTML received from server');
                }

                this.updateUI(data.html, keyword, page, sort);
            } catch (error) {
                console.error('Search error:', error);
                utils.handleError(error, elements.productContainer);
            } finally {
                utils.hideLoading();
            }
        },

        updateUI(html, keyword, page, sort) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Update search results count
            this.updateSearchCount(doc);
            
            // Update products
            this.updateProducts(doc);
            
            // Update pagination
            this.updatePagination(doc, keyword, page, sort);
            
            // Update sorting
            this.updateSorting(doc, keyword, page, sort);
            
            // Update URL
            utils.updateURL({
                q: keyword,
                page: page,
                sort: sort
            });
        },

        updateSearchCount(doc) {
            const searchResultsCount = doc.querySelector('.text-muted.fs-15');
            if (searchResultsCount) {
                const existingCount = document.querySelector('.text-muted.fs-15');
                if (existingCount) {
                    existingCount.remove();
                }
                document.querySelector('.col-md-6').appendChild(searchResultsCount.cloneNode(true));
            }
        },

        updateProducts(doc) {
            const newProducts = doc.querySelector('.shop-modern');
            if (!elements.productContainer) return;

            // Destroy existing Isotope
            if ($(elements.productContainer).data('isotope')) {
                $(elements.productContainer).isotope('destroy');
            }

            // Reset container
            elements.productContainer.innerHTML = '';
            const gridSizer = document.createElement('div');
            gridSizer.className = 'grid-sizer';
            elements.productContainer.appendChild(gridSizer);

            // Add new products if they exist
            if (newProducts) {
                const newProductItems = newProducts.querySelectorAll('.grid-item');
                if (newProductItems.length > 0) {
                    newProductItems.forEach(item => {
                        elements.productContainer.appendChild(item.cloneNode(true));
                    });
                } else {
                    // If no products found, show a message
                    elements.productContainer.innerHTML = `
                        <div class="col-12 text-center">
                            <p class="text-muted">Không tìm thấy sản phẩm phù hợp với từ khóa tìm kiếm.</p>
                        </div>
                    `;
                }
            } else {
                // If no products container found in response, show a message
                elements.productContainer.innerHTML = `
                    <div class="col-12 text-center">
                        <p class="text-muted">Không tìm thấy sản phẩm phù hợp với từ khóa tìm kiếm.</p>
                    </div>
                `;
            }

            // Reinitialize Isotope only if there are products
            if (newProducts && newProducts.querySelectorAll('.grid-item').length > 0) {
                this.initializeIsotope();
            }
        },

        initializeIsotope() {
            const isotopeConfig = {
                layoutMode: 'fitRows',
                itemSelector: '.grid-item',
                percentPosition: true,
                stagger: 0
            };

            if (typeof imagesLoaded === 'function' && typeof $.fn.isotope === 'function') {
                $(elements.productContainer).imagesLoaded(function() {
                    $(elements.productContainer).removeClass('grid-loading');
                    $(elements.productContainer).isotope(isotopeConfig);
                    $(elements.productContainer).isotope('layout');
                });
            } else if (typeof $.fn.isotope === 'function') {
                $(elements.productContainer).isotope(isotopeConfig);
                $(elements.productContainer).isotope('layout');
            }
        },

        updatePagination(doc, keyword, page, sort) {
            const pagination = doc.querySelector('.pagination');
            if (!pagination) return;

            const existingPagination = document.querySelector('.pagination');
            if (existingPagination) {
                existingPagination.remove();
            }

            // Create a container for pagination to ensure proper centering
            const paginationContainer = document.createElement('div');
            paginationContainer.className = 'd-flex justify-content-center mt-4';
            paginationContainer.appendChild(pagination.cloneNode(true));

            // Find the appropriate container to append pagination
            const shopModern = document.querySelector('.shop-modern');
            if (shopModern) {
                shopModern.after(paginationContainer);
            }

            // Add click handlers to pagination links
            const paginationLinks = document.querySelectorAll('.pagination a');
            paginationLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const newPage = link.getAttribute('href').match(/page=(\d+)/)?.[1] || 1;
                    state.currentPage = parseInt(newPage);
                    this.perform(keyword, state.currentPage, sort);
                });
            });
        },

        updateSorting(doc, keyword, page, sort) {
            const sortSelect = document.querySelector('select[name="sort"]');
            if (!sortSelect) return;

            // Remove the onchange attribute to prevent form submission
            sortSelect.removeAttribute('onchange');
            sortSelect.value = sort;

            // Prevent form submission
            const sortForm = sortSelect.closest('form');
            if (sortForm) {
                sortForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                });

                // Remove all hidden inputs to prevent them from affecting the search
                const hiddenInputs = sortForm.querySelectorAll('input[type="hidden"]');
                hiddenInputs.forEach(input => input.remove());
            }

            // Add change event listener
            sortSelect.addEventListener('change', (e) => {
                e.preventDefault();
                e.stopPropagation();

                if (!state.currentKeyword) {
                    sortSelect.value = 'default';
                    return;
                }

                const newSort = e.target.value;
                state.currentSort = newSort;
                state.currentPage = 1;

                // Log for debugging
                console.log('Sorting changed:', {
                    keyword: state.currentKeyword,
                    page: state.currentPage,
                    sort: newSort
                });

                // Perform search with new sort
                this.perform(state.currentKeyword, state.currentPage, newSort);
            });
        },

        async showSuggestions(term) {
            if (!elements.searchSuggestions) return;

            const trimmedTerm = term ? term.trim() : '';
            elements.searchSuggestions.innerHTML = ''; // Clear previous content

            // Cập nhật từ khóa cuối cùng được yêu cầu
            state.lastRequestedTerm = trimmedTerm;

            if (trimmedTerm === '') {
                // Display history and trending
                let contentHtml = `
                    <div class="suggestions-section mb-3">
                        <h6 class="mb-2 fw-bold text-dark" style="font-size: 16px;">
                            <i class="fa fa-history text-danger me-2"></i>Lịch sử tìm kiếm
                        </h6>
                        <div class="history-list-dynamic">
                            ${searchHistory.display()}
                        </div>
                        ${searchHistory.get().length > 0 ? `<button class="btn btn-sm btn-outline-danger btn-clear-history mt-2" style="border: none !important; color: #dc3545 !important; background: transparent !important;">Xóa lịch sử</button>` : ''}
                    </div>
                    <div class="products-section">
                        <h6 class="mb-2 fw-bold text-dark" style="font-size: 16px;">
                            <i class="fa fa-fire text-danger me-2"></i>Xu hướng tìm kiếm
                        </h6>
                        <div class="trending-list-dynamic">
                            ${handlers.displayTrendingSearches()}
                        </div>
                    </div>
                `;
                elements.searchSuggestions.innerHTML = contentHtml;

                // Re-attach event listeners for history and trending items
                elements.searchSuggestions.querySelectorAll('.history-item .text-content').forEach(item => {
                    item.addEventListener('click', () => {
                        const keyword = item.querySelector('span').textContent.trim();
                        elements.searchInput.value = keyword;
                        state.currentKeyword = keyword;
                        state.currentPage = 1;
                        elements.searchSuggestions.style.display = 'none'; // Hide dropdown
                        this.perform(keyword);
                    });
                });
                elements.searchSuggestions.querySelectorAll('.remove-history-item').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        searchHistory.remove(e.target.dataset.keyword);
                        search.showSuggestions(''); // Re-render
                    });
                });
                const clearBtn = elements.searchSuggestions.querySelector('.btn-clear-history');
                if (clearBtn) {
                    clearBtn.addEventListener('click', () => {
                        searchHistory.clear();
                        search.showSuggestions(''); // Re-render
                    });
                }
                elements.searchSuggestions.querySelectorAll('.trend-tag').forEach(tag => {
                    tag.addEventListener('click', (e) => {
                        e.preventDefault();
                        const keyword = tag.querySelector('span').textContent.trim();
                        elements.searchInput.value = keyword;
                        elements.searchSuggestions.style.display = 'none'; // Hide dropdown
                        state.currentKeyword = keyword;
                        state.currentPage = 1;
                        this.perform(keyword);
                    });
                });

                elements.searchSuggestions.style.display = 'block';

                return;
            }

            // If there's a search term, proceed with fetching suggestions
            try {
                // Lấy từ khóa cho yêu cầu hiện tại để so sánh sau này
                const currentTermForRequest = trimmedTerm;

                // Gọi API lấy gợi ý
                const response = await fetch(`${CONFIG.API_ENDPOINTS.SUGGESTIONS}?q=${encodeURIComponent(currentTermForRequest)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();

                // QUAN TRỌNG: Chỉ cập nhật nếu đây là phản hồi cho yêu cầu gần nhất
                if (state.lastRequestedTerm !== currentTermForRequest) {
                    console.log(`Ignoring outdated suggestion response for term: ${currentTermForRequest}. Current term is: ${state.lastRequestedTerm}`);
                    return; // Bỏ qua phản hồi cũ
                }

                const suggestions = data.suggestions || [];
                const featuredProducts = data.featured_products || [];

                // Cập nhật nội dung search-suggestions
                elements.searchSuggestions.innerHTML = `
                    <div class="suggestions-section mb-3">
                        <h6 class="mb-2 fw-bold text-dark" style="font-size: 16px;">
                            <i class="fa fa-search text-danger me-2"></i>Gợi ý tìm kiếm
                        </h6>
                        <div class="suggestions-list">
                            ${suggestions.length > 0 ? suggestions.map(suggestion => `
                                <div class="suggestion-item p-2 border-bottom" style="cursor: pointer;">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-search text-muted"></i>
                                        <span class="ms-2" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">${suggestion.name}</span>
                                    </div>
                                </div>
                            `).join('') : `
                                <div class="p-2 text-center text-muted">
                                    Không tìm thấy gợi ý phù hợp
                                </div>
                            `}
                        </div>
                    </div>
                    <div class="products-section">
                        <h6 class="mb-2 fw-bold text-dark" style="font-size: 16px;">
                            <i class="fa fa-star text-danger me-2"></i>Sản phẩm nổi bật
                        </h6>
                        <div class="products-list">
                            ${featuredProducts.length > 0 ? featuredProducts.map(product => `
                                <div class="product-item p-2 border-bottom" style="cursor: pointer;" data-product-id="${product.id}">
                                    <div class="d-flex align-items-center">
                                        <div class="product-image" style="width: 60px; height: 60px; margin-right: 15px;">
                                            <img src="${product.image}" alt="${product.name}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                                        </div>
                                        <div class="product-info" style="flex: 1;">
                                            <div class="product-name" style="font-size: 14px; margin-bottom: 2px; line-height: 2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">${product.name}</div>
                                            <div class="product-price d-flex align-items-center gap-2" style="line-height: 1;">
                                                <span class="current-price text-danger fw-bold">${product.price}</span>
                                                ${product.old_price ? `
                                                    <span class="old-price text-muted" style="text-decoration: line-through; font-size: 13px;">${product.old_price}</span>
                                                ` : ''}
                                                ${product.discount ? `
                                                    <span class="discount" style="background: #f60; color: white; padding: 2px 6px; border-radius: 3px; font-size: 12px;">${product.discount}</span>
                                                ` : ''}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `).join('') : `
                                <div class="p-2 text-center text-muted">
                                    Không có sản phẩm nổi bật
                                </div>
                            `}
                        </div>
                    </div>
                `;

                // Thêm event listeners cho các suggestion items
                elements.searchSuggestions.querySelectorAll('.suggestion-item').forEach(item => {
                    item.addEventListener('click', () => {
                        const keyword = item.querySelector('span').textContent.trim();
                        elements.searchInput.value = keyword;
                        state.currentKeyword = keyword;
                        state.currentPage = 1;
                        elements.searchSuggestions.style.display = 'none'; // Hide dropdown
                        this.perform(keyword);
                    });
                });

                // Thêm event listeners cho các product items
                elements.searchSuggestions.querySelectorAll('.product-item').forEach(item => {
                    item.addEventListener('click', () => {
                        const productId = item.dataset.productId;
                        if (productId) {
                            window.location.href = `/aonam/${productId}`;
                        }
                    });
                });
                elements.searchSuggestions.style.display = 'block';

            } catch (error) {
                // Chỉ hiển thị lỗi nếu đây là lỗi cho yêu cầu gần nhất
                if (state.lastRequestedTerm === trimmedTerm) {
                    console.error('Error fetching suggestions:', error);
                    elements.searchSuggestions.innerHTML = `
                        <div class="p-2 text-center text-danger">
                            <i class="fa fa-exclamation-circle me-2"></i>
                            Có lỗi xảy ra khi tải gợi ý. Vui lòng thử lại sau.
                        </div>
                    `;
                }
            }
        }
    };

    // Event Handlers
    const handlers = {
        init() {
            if (!elements.searchInput) {
                console.error('Không tìm thấy ô tìm kiếm');
                return;
            }

            // No longer need to updateUI or displayTrendingSearches here directly
            // searchHistory.updateUI(); // This will be handled by showSuggestions
            // this.displayTrendingSearches(); // This will be handled by showSuggestions

            // Set up event listeners
            this.setupEventListeners();

            // If there's a search query in the URL, perform the search
            if (searchQuery) {
                elements.searchInput.value = searchQuery;
                search.perform(searchQuery, state.currentPage, state.currentSort);
            }
        },

        setupEventListeners() {
            // Search input events
            elements.searchInput.addEventListener('focus', () => {
                // When focused, always show the suggestions container
                // Then, show history/trending if input is empty
                const searchValue = elements.searchInput.value.trim();
                if (searchValue.length === 0) {
                    search.showSuggestions(''); // Show history/trending
                } else {
                    search.showSuggestions(searchValue); // Show current suggestions
                }
            });

            elements.searchInput.addEventListener('input', utils.debounce(() => {
                search.showSuggestions(elements.searchInput.value);
            }, CONFIG.DEBOUNCE_DELAY));

            elements.searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    const keyword = elements.searchInput.value.trim();
                    if (keyword.length > 0) {
                        state.currentKeyword = keyword;
                        state.currentPage = 1;
                        search.perform(keyword);
                    }
                }
            });

            // Clear history button is now dynamically added and handled in showSuggestions
            if (elements.clearHistoryBtn) {
                // elements.clearHistoryBtn.addEventListener('click', () => { // Remove this
                //     searchHistory.clear();
                // });
            }

            // Clear input button
            if (elements.clearInput) {
                elements.searchInput.addEventListener('input', () => {
                    elements.clearInput.style.display = elements.searchInput.value.length > 0 ? 'block' : 'none';
                });

                elements.clearInput.addEventListener('click', () => {
                    elements.searchInput.value = '';
                    elements.searchInput.focus();
                    elements.clearInput.style.display = 'none';
                    search.showSuggestions(''); // Show history/trending after clearing
                });
            }

            // Close suggestions when clicking outside
            document.addEventListener('click', (e) => {
                if (elements.searchInput && elements.searchSuggestions) {
                    if (!elements.searchInput.contains(e.target) && !elements.searchSuggestions.contains(e.target)) {
                        elements.searchSuggestions.style.display = 'none';
                    }
                }
            });
        },

        displayTrendingSearches() {
            // if (!elements.trendingList) return; // This will be removed

            // elements.trendingList.innerHTML = ''; // This will be removed
            return trendingSearches.map(keyword => `
                <a href="#" class="trend-tag">
                    <i class="fa fa-fire"></i>
                    <span>${keyword}</span>
                </a>
            `).join('');
        }
    };

    // Initialize the search functionality
    handlers.init();
});

document.addEventListener('DOMContentLoaded', function() {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('#navbarNav');
    const body = document.body;
    
    // Prevent menu from auto-closing
    navbarToggler.addEventListener('click', function(e) {
        e.stopPropagation();
        
        // Toggle body scroll lock
        if (navbarCollapse.classList.contains('show')) {
            body.classList.remove('menu-open');
        } else {
            body.classList.add('menu-open');
        }
    });
    
    // Close menu when clicking outside (optional)
    document.addEventListener('click', function(e) {
        if (!navbarCollapse.contains(e.target) && !navbarToggler.contains(e.target)) {
            if (navbarCollapse.classList.contains('show')) {
                navbarToggler.click();
            }
        }
    });
    
    // Handle Bootstrap collapse events
    navbarCollapse.addEventListener('hidden.bs.collapse', function() {
        body.classList.remove('menu-open');
        navbarToggler.setAttribute('aria-expanded', 'false');
    });
    
    navbarCollapse.addEventListener('shown.bs.collapse', function() {
        body.classList.add('menu-open');
        navbarToggler.setAttribute('aria-expanded', 'true');
    });
    
    // Prevent dropdown clicks from closing mobile menu
    const dropdownItems = document.querySelectorAll('.dropdown-item');
    dropdownItems.forEach(item => {
        item.addEventListener('click', function(e) {
            if (window.innerWidth < 992) {
                e.stopPropagation();
            }
        });
    });
});
    
    