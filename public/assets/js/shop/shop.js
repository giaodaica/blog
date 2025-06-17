document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filterForm');
    const productGrid = document.querySelector('.shop-modern');
    const loadingOverlay = document.createElement('div');
    loadingOverlay.className = 'loading-overlay';
    loadingOverlay.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
    document.body.appendChild(loadingOverlay);

    // State Management
    const state = {
        currentPage: 1,
        currentSort: 'default',
        isLoading: false
    };

    // Get URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const page = urlParams.get('page') || 1;
    const sort = urlParams.get('sort') || 'default';

    // Initialize state from URL parameters
    state.currentPage = parseInt(page);
    state.currentSort = sort;

    // Handle all filter changes
    const filterInputs = document.querySelectorAll('input[type="checkbox"], input[type="radio"]');
    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            state.currentPage = 1; // Reset to first page when filter changes
            filterProducts();
        });
    });

    // Handle pagination clicks
    document.addEventListener('click', function(e) {
        const paginationLink = e.target.closest('.pagination a');
        if (paginationLink) {
            e.preventDefault();
            const newPage = paginationLink.getAttribute('href').match(/page=(\d+)/)?.[1] || 1;
            state.currentPage = parseInt(newPage);
            filterProducts();
        }
    });

    // Handle sorting changes
    const sortSelect = document.querySelector('select[name="sort"]');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            state.currentSort = this.value;
            state.currentPage = 1;
            filterProducts();
        });
    }

    function filterProducts() {
        if (state.isLoading) return;
        state.isLoading = true;
        loadingOverlay.style.display = 'flex';

        const formData = new FormData(filterForm);
        const queryParams = new URLSearchParams();

        // Add all form data to query params
        for (let [key, value] of formData.entries()) {
            if (value) {
                queryParams.append(key, value);
            }
        }

        // Add pagination and sorting
        queryParams.append('page', state.currentPage);
        if (state.currentSort !== 'default') {
            queryParams.append('sort', state.currentSort);
        }

        const queryString = queryParams.toString();
        const url = `${window.location.pathname}?${queryString}`;

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            // Update URL without reload
            const newUrl = queryString ? `${window.location.pathname}?${queryString}` : window.location.pathname;
            window.history.pushState({ path: newUrl }, '', newUrl);
            
            // Update products grid
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newProducts = doc.querySelector('.shop-modern');
            if (newProducts) {
                // Destroy existing Isotope instance if any
                if ($(productGrid).data('isotope')) {
                    $(productGrid).isotope('destroy');
                }

                // Keep the grid-sizer element
                const gridSizer = productGrid.querySelector('.grid-sizer');
                productGrid.innerHTML = '';
                if (gridSizer) {
                    productGrid.appendChild(gridSizer);
                }
                
                // Check if there are any products
                const noProductsMessage = newProducts.querySelector('.no-products-message');
                if (noProductsMessage) {
                    productGrid.appendChild(noProductsMessage.cloneNode(true));
                } else {
                    // Add new products
                    const newProductItems = newProducts.querySelectorAll('.grid-item');
                    newProductItems.forEach(item => {
                        productGrid.appendChild(item.cloneNode(true));
                    });
                    
                    // Reinitialize Isotope layout after new items are added
                    if (typeof imagesLoaded === 'function' && typeof $.fn.isotope === 'function') {
                        $(productGrid).imagesLoaded(function() {
                            $(productGrid).removeClass('grid-loading');
                            $(productGrid).isotope({
                                layoutMode: 'masonry',
                                itemSelector: '.grid-item',
                                percentPosition: true,
                                stagger: 0,
                                masonry: {
                                    columnWidth: '.grid-sizer',
                                }
                            });
                        });
                    } else if (typeof $.fn.isotope === 'function') {
                        // Fallback if imagesLoaded is not available
                        $(productGrid).isotope({
                            layoutMode: 'masonry',
                            itemSelector: '.grid-item',
                            percentPosition: true,
                            stagger: 0,
                            masonry: {
                                columnWidth: '.grid-sizer',
                            }
                        });
                    }
                }
            }

            // Update pagination
            const newPagination = doc.querySelector('.pagination');
            const currentPagination = document.querySelector('.pagination');
            if (newPagination && currentPagination) {
                currentPagination.innerHTML = newPagination.innerHTML;
            }

            // Update category counts
            const newCategoryCounts = doc.querySelectorAll('.category-filter .item-qty');
            const currentCategoryCounts = document.querySelectorAll('.category-filter .item-qty');
            newCategoryCounts.forEach((newCount, index) => {
                if (currentCategoryCounts[index]) {
                    currentCategoryCounts[index].textContent = newCount.textContent;
                }
            });

            // Update color filters
            const newColorFilters = doc.querySelector('.color-filter');
            const currentColorFilters = document.querySelector('.color-filter');
            if (newColorFilters && currentColorFilters) {
                // Store currently checked colors
                const checkedColors = Array.from(currentColorFilters.querySelectorAll('input[type="checkbox"]:checked'))
                    .map(input => input.value);
                
                // Update the color filter section
                currentColorFilters.innerHTML = newColorFilters.innerHTML;
                
                // Re-check previously checked colors if they still exist
                checkedColors.forEach(colorId => {
                    const checkbox = currentColorFilters.querySelector(`input[value="${colorId}"]`);
                    if (checkbox) {
                        checkbox.checked = true;
                    }
                });
            }

            // Update size filters
            const newSizeFilters = doc.querySelector('.size-filter');
            const currentSizeFilters = document.querySelector('.size-filter');
            if (newSizeFilters && currentSizeFilters) {
                // Store currently checked sizes
                const checkedSizes = Array.from(currentSizeFilters.querySelectorAll('input[type="checkbox"]:checked'))
                    .map(input => input.value);
                
                // Update the size filter section
                currentSizeFilters.innerHTML = newSizeFilters.innerHTML;
                
                // Re-check previously checked sizes if they still exist
                checkedSizes.forEach(sizeId => {
                    const checkbox = currentSizeFilters.querySelector(`input[value="${sizeId}"]`);
                    if (checkbox) {
                        checkbox.checked = true;
                    }
                });
            }

            // Reattach event listeners to new filter inputs
            const newFilterInputs = document.querySelectorAll('input[type="checkbox"], input[type="radio"]');
            newFilterInputs.forEach(input => {
                input.addEventListener('change', function() {
                    state.currentPage = 1;
                    filterProducts();
                });
            });
        })
        .catch(error => {
            console.error('Error:', error);
        })
        .finally(() => {
            // Hide loading state
            loadingOverlay.style.display = 'none';
            state.isLoading = false;
        });
    }
});
document.addEventListener('DOMContentLoaded', function() {
    const toggleButtons = document.querySelectorAll('.toggle-filter');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filterSection = this.closest('.mb-30px').querySelector('ul');
            const isHidden = filterSection.style.display === 'none';
            
            // Toggle the section
            filterSection.style.display = isHidden ? 'block' : 'none';
            
            // Toggle the arrow icon
            this.classList.toggle('fa-chevron-down');
            this.classList.toggle('fa-chevron-up');
        });
    });

    // Handle show more/collapse categories
    const showMoreBtn = document.querySelector('.show-more-categories');
    const collapseBtn = document.querySelector('.collapse-categories');
    const hiddenCategories = document.querySelectorAll('.hidden-category');

    if (showMoreBtn) {
        showMoreBtn.addEventListener('click', function() {
            hiddenCategories.forEach(category => {
                category.classList.remove('hidden-category');
            });
            this.classList.add('hidden');
            if (collapseBtn) {
                collapseBtn.classList.add('visible');
            }
        });
    }

    if (collapseBtn) {
        collapseBtn.addEventListener('click', function() {
            hiddenCategories.forEach(category => {
                category.classList.add('hidden-category');
            });
            this.classList.remove('visible');
            if (showMoreBtn) {
                showMoreBtn.classList.remove('hidden');
            }
        });
    }
});