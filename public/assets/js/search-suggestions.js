document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const searchSuggestions = document.querySelector('.search-suggestions');
    const historyList = document.querySelector('.history-list');
    const clearHistoryBtn = document.querySelector('.btn-clear-history');
    const closeSuggestionsBtn = document.querySelector('.btn-close-suggestions');
    const trendingList = document.querySelector('.trending-list');
    const autocompleteResults = document.getElementById('autocomplete-results');
    const MAX_HISTORY_ITEMS = 5;

    // Dummy data for trending searches (replace with API calls)
    const trendingSearches = [
        "Áo thun nam", "Quần jean nữ", "Váy liền thân", "Giày thể thao", 
        "Túi xách", "Đồng hồ", "Kính mát", "Phụ kiện"
    ];

    // Lấy lịch sử tìm kiếm từ localStorage
    function getSearchHistory() {
        const history = localStorage.getItem('searchHistory');
        return history ? JSON.parse(history) : [];
    }

    // Lưu lịch sử tìm kiếm vào localStorage
    function saveSearchHistory(keyword) {
        let history = getSearchHistory();
        history = history.filter(item => item !== keyword);
        history.unshift(keyword);
        if (history.length > MAX_HISTORY_ITEMS) {
            history = history.slice(0, MAX_HISTORY_ITEMS);
        }
        localStorage.setItem('searchHistory', JSON.stringify(history));
        updateClearHistoryButton();
    }

    // Xóa một mục lịch sử
    function removeSearchHistoryItem(keywordToRemove) {
        let history = getSearchHistory();
        history = history.filter(item => item !== keywordToRemove);
        localStorage.setItem('searchHistory', JSON.stringify(history));
        displaySearchHistory();
        updateClearHistoryButton();
    }

    // Hiển thị lịch sử tìm kiếm
    function displaySearchHistory() {
        const history = getSearchHistory();
        historyList.innerHTML = '';
        
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
                    searchInput.value = keyword;
                    searchSuggestions.style.display = 'none';
                    performSearch(keyword);
                });
                li.querySelector('.remove-history-item').addEventListener('click', (e) => {
                    e.stopPropagation();
                    removeSearchHistoryItem(e.target.dataset.keyword);
                });
                historyList.appendChild(li);
            });
        } else {
            historyList.innerHTML = '<li class="mb-2 fw-bold text-dark" style="font-size: 16px;">Chưa có lịch sử tìm kiếm</li>';
        }
        updateClearHistoryButton();
    }

    // Cập nhật trạng thái nút xóa tất cả
    function updateClearHistoryButton() {
        const history = getSearchHistory();
        clearHistoryBtn.style.display = history.length > 0 ? 'block' : 'none';
    }

    // Hiển thị xu hướng tìm kiếm
    function displayTrendingSearches() {
        trendingList.innerHTML = '';
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
                searchInput.value = keyword;
                searchSuggestions.style.display = 'none';
                performSearch(keyword);
            });
            trendingList.appendChild(tag);
        });
    }

    // Thực hiện tìm kiếm
    function performSearch(keyword) {
        saveSearchHistory(keyword);
        // Lưu giá trị tìm kiếm hiện tại vào localStorage
        localStorage.setItem('currentSearch', keyword);
        window.location.href = `/search?q=${encodeURIComponent(keyword)}`;
    }

    // Hiển thị gợi ý tìm kiếm
    async function showSuggestions(term) {
        if (!term) {
            autocompleteResults.style.display = 'none';
            return;
        }

        try {
            const response = await fetch(`/search/suggestions?q=${encodeURIComponent(term)}`);
            const suggestions = await response.json();

            autocompleteResults.innerHTML = '';
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
                        searchInput.value = suggestion.name;
                        performSearch(suggestion.name);
                    });
                    autocompleteResults.appendChild(div);
                });
                autocompleteResults.style.display = 'block';
            } else {
                autocompleteResults.style.display = 'none';
            }
        } catch (error) {
            console.error('Error fetching suggestions:', error);
            autocompleteResults.style.display = 'none';
        }
    }

    // Xử lý sự kiện focus vào ô tìm kiếm
    searchInput.addEventListener('focus', function() {
        displaySearchHistory();
        displayTrendingSearches();
        searchSuggestions.style.display = 'block';
    });

    // Xử lý sự kiện nhập liệu
    let debounceTimer;
    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        if (this.value.length > 0) {
            debounceTimer = setTimeout(() => {
                showSuggestions(this.value);
            }, 300); // Debounce 300ms
        } else {
            displaySearchHistory();
            displayTrendingSearches();
            autocompleteResults.style.display = 'none';
        }
    });

    // Xử lý sự kiện nhấn Enter
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const keyword = this.value.trim();
            if (keyword.length > 0) {
                performSearch(keyword);
            }
        }
    });

    // Xử lý sự kiện click nút xóa tất cả lịch sử
    clearHistoryBtn.addEventListener('click', function() {
        localStorage.removeItem('searchHistory');
        displaySearchHistory();
        updateClearHistoryButton();
    });

    // Ẩn suggestions khi click ra ngoài
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchSuggestions.contains(e.target)) {
            searchSuggestions.style.display = 'none';
        }
    });

    const clearInput = document.getElementById('clearInput');

    searchInput.addEventListener('input', function () {
        clearInput.style.display = this.value.length > 0 ? 'block' : 'none';
    });
    
    clearInput.addEventListener('click', function () {
        searchInput.value = '';
        searchInput.focus();
        clearInput.style.display = 'none';
        displaySearchHistory();
        displayTrendingSearches();
        autocompleteResults.style.display = 'none';
    });
    
    // Khởi tạo hiển thị lịch sử và xu hướng khi tải trang
    displaySearchHistory();
    displayTrendingSearches();
    
    // Khôi phục giá trị tìm kiếm từ localStorage nếu có
    const savedSearch = localStorage.getItem('currentSearch');
    if (savedSearch) {
        searchInput.value = savedSearch;
        // Xóa giá trị đã lưu sau khi khôi phục
        localStorage.removeItem('currentSearch');
    }
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
