document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filterForm');
    const productGrid = document.querySelector('.shop-modern');
    const loadingOverlay = document.createElement('div');
    loadingOverlay.className = 'loading-overlay';
    loadingOverlay.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
    document.body.appendChild(loadingOverlay);

    // Handle all filter changes
    const filterInputs = document.querySelectorAll('input[type="checkbox"], input[type="radio"]');
    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            filterProducts();
        });
    });

    function filterProducts() {
        const formData = new FormData(filterForm);
        const queryString = new URLSearchParams(formData).toString();
        
        // Show loading state
        loadingOverlay.style.display = 'flex';
        
        // Make AJAX request
        fetch(`${filterForm.action}?${queryString}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            // Update URL without reload
            const newUrl = `${window.location.pathname}?${queryString}`;
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

            // Update category counts
            const newCategoryCounts = doc.querySelectorAll('.category-filter .item-qty');
            const currentCategoryCounts = document.querySelectorAll('.category-filter .item-qty');
            newCategoryCounts.forEach((newCount, index) => {
                if (currentCategoryCounts[index]) {
                    currentCategoryCounts[index].textContent = newCount.textContent;
                }
            });

            // Update color counts
            const newColorCounts = doc.querySelectorAll('.color-filter .item-qty');
            const currentColorCounts = document.querySelectorAll('.color-filter .item-qty');
            newColorCounts.forEach((newCount, index) => {
                if (currentColorCounts[index]) {
                    currentColorCounts[index].textContent = newCount.textContent;
                }
            });

            // Update size counts
            const newSizeCounts = doc.querySelectorAll('.size-filter .item-qty');
            const currentSizeCounts = document.querySelectorAll('.size-filter .item-qty');
            newSizeCounts.forEach((newCount, index) => {
                if (currentSizeCounts[index]) {
                    currentSizeCounts[index].textContent = newCount.textContent;
                }
            });
        })
        .catch(error => {
            console.error('Error:', error);
        })
        .finally(() => {
            // Hide loading state
            loadingOverlay.style.display = 'none';
        });
    }
});
