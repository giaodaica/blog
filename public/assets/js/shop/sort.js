document.addEventListener('DOMContentLoaded', function() {
    const sortSelect = document.getElementById('sort');
    if (!sortSelect) return;

    sortSelect.addEventListener('change', function() {
        const currentUrl = new URL(window.location.href);
        const sortValue = this.value;
        const isSearchPage = window.location.pathname === '/search';
        
        // Update sort parameter in URL
        if (sortValue) {
            currentUrl.searchParams.set('sort', sortValue);
        } else {
            currentUrl.searchParams.delete('sort');
        }

        // Get all current filter parameters
        const form = this.closest('form');
        const formData = new FormData(form);
        const params = new URLSearchParams();

        // Add all form data to params
        for (let [key, value] of formData.entries()) {
            if (key !== 'sort') { // Skip sort as we already handled it
                params.append(key, value);
            }
        }

        // Add search query if exists
        const searchQuery = currentUrl.searchParams.get('q');
        if (searchQuery) {
            params.append('q', searchQuery);
        }

        // Add sort parameter
        if (sortValue) {
            params.append('sort', sortValue);
        }

        // Make AJAX request
        fetch(`${window.location.pathname}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            // Update URL without reload
            window.history.pushState({ path: currentUrl.toString() }, '', currentUrl.toString());
            
            // Update products grid
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const productGrid = document.querySelector('.shop-modern');
            const newProducts = doc.querySelector('.shop-modern');
            
            if (productGrid && newProducts) {
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
                
                // Add new products
                const newProductItems = newProducts.querySelectorAll('.grid-item');
                newProductItems.forEach(item => {
                    productGrid.appendChild(item.cloneNode(true));
                });

                // Reinitialize Isotope
                if (typeof imagesLoaded === 'function' && typeof $.fn.isotope === 'function') {
                    $(productGrid).imagesLoaded(function() {
                        $(productGrid).removeClass('grid-loading');
                        $(productGrid).isotope({
                            layoutMode: 'fitRows',
                            itemSelector: '.grid-item',
                            percentPosition: true,
                            stagger: 0
                        });
                        $(productGrid).isotope('layout');
                    });
                }
            }

            // Update search summary if exists
            const searchSummary = document.getElementById('search-summary');
            const newSearchSummary = doc.getElementById('search-summary');
            if (searchSummary && newSearchSummary) {
                searchSummary.innerHTML = newSearchSummary.innerHTML;
            }

            // Update pagination if exists
            const pagination = document.querySelector('.pagination');
            const newPagination = doc.querySelector('.pagination');
            if (pagination && newPagination) {
                pagination.innerHTML = newPagination.innerHTML;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
}); 