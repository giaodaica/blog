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
        debounceTimer: null
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
            elements.historyList.innerHTML = '';
            
            if (history.length > 0) {
                history.forEach(keyword => {
                    const li = document.createElement('li');
                    li.innerHTML = `
                        <div class="text-content">
                            <i class="fa fa-history"></i>
                            <span>${keyword}</span>
                        </div>
                        <button class="remove-history-item" data-keyword="${keyword}">&times;</button>
                    `;
                    
                    li.querySelector('.text-content').addEventListener('click', () => {
                        elements.searchInput.value = keyword;
                        if (elements.searchSuggestions) {
                            elements.searchSuggestions.style.display = 'none';
                        }
                        state.currentKeyword = keyword;
                        state.currentPage = 1;
                        search.perform(keyword);
                    });

                    li.querySelector('.remove-history-item').addEventListener('click', (e) => {
                        e.stopPropagation();
                        this.remove(e.target.dataset.keyword);
                    });

                    elements.historyList.appendChild(li);
                });
            } else {
                elements.historyList.innerHTML = '<li class="mb-2 fw-bold text-dark" style="font-size: 16px;">Chưa có lịch sử tìm kiếm</li>';
            }
        },

        updateClearButton() {
            const history = this.get();
            elements.clearHistoryBtn.style.display = history.length > 0 ? 'block' : 'none';
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
            if (!elements.autocompleteResults || !term) {
                if (elements.autocompleteResults) {
                    elements.autocompleteResults.style.display = 'none';
                }
                return;
            }

            try {
                const response = await fetch(`${CONFIG.API_ENDPOINTS.SUGGESTIONS}?q=${encodeURIComponent(term)}`);
                const suggestions = await response.json();

                elements.autocompleteResults.innerHTML = '';
                if (suggestions.length > 0) {
                    suggestions.forEach(suggestion => {
                        const div = document.createElement('div');
                        div.className = 'p-2 border-bottom suggestion-item';
                        div.innerHTML = `
                            <div class="d-flex align-items-center">
                                <i class="fa fa-search text-muted me-2"></i>
                                <span>${suggestion.name}</span>
                            </div>
                        `;
                        div.addEventListener('click', () => {
                            elements.searchInput.value = suggestion.name;
                            state.currentKeyword = suggestion.name;
                            state.currentPage = 1;
                            this.perform(suggestion.name);
                        });
                        elements.autocompleteResults.appendChild(div);
                    });
                    elements.autocompleteResults.style.display = 'block';
                } else {
                    elements.autocompleteResults.style.display = 'none';
                }
            } catch (error) {
                console.error('Error fetching suggestions:', error);
                elements.autocompleteResults.style.display = 'none';
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

            // Initialize search history and trending searches
            searchHistory.updateUI();
            this.displayTrendingSearches();

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
                if (elements.historyList) searchHistory.display();
                if (elements.trendingList) this.displayTrendingSearches();
                if (elements.searchSuggestions) {
                    elements.searchSuggestions.style.display = 'block';
                }
            });

            elements.searchInput.addEventListener('input', utils.debounce(() => {
                if (elements.searchInput.value.length > 0) {
                    search.showSuggestions(elements.searchInput.value);
                } else {
                    if (elements.historyList) searchHistory.display();
                    if (elements.trendingList) this.displayTrendingSearches();
                    if (elements.autocompleteResults) {
                        elements.autocompleteResults.style.display = 'none';
                    }
                }
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

            // Clear history button
            if (elements.clearHistoryBtn) {
                elements.clearHistoryBtn.addEventListener('click', () => {
                    searchHistory.clear();
                });
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
                    if (elements.historyList) searchHistory.display();
                    if (elements.trendingList) this.displayTrendingSearches();
                    if (elements.autocompleteResults) {
                        elements.autocompleteResults.style.display = 'none';
                    }
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
            if (!elements.trendingList) return;

            elements.trendingList.innerHTML = '';
            trendingSearches.forEach(keyword => {
                const tag = document.createElement('a');
                tag.href = '#';
                tag.className = 'trend-tag';
                tag.innerHTML = `
                    <i class="fa fa-fire"></i>
                    <span>${keyword}</span>
                `;
                tag.addEventListener('click', (e) => {
                    e.preventDefault();
                    elements.searchInput.value = keyword;
                    if (elements.searchSuggestions) {
                        elements.searchSuggestions.style.display = 'none';
                    }
                    state.currentKeyword = keyword;
                    state.currentPage = 1;
                    search.perform(keyword);
                });
                elements.trendingList.appendChild(tag);
            });
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
    