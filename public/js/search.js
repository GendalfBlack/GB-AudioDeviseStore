document.addEventListener('DOMContentLoaded', function() {
    var searchParams = new URLSearchParams(window.location.search);
    var isViewProductPage = searchParams.get('action') === 'view_product';
    var isAddToBasketPage = window.location.pathname.includes('add_to_basket.php');
    var hideSearchContainer = isViewProductPage || isAddToBasketPage;
    var searchContainer = document.getElementById('search-container');

    if (hideSearchContainer) {
        searchContainer.style.display = 'none';
    } else {
        searchContainer.style.display = 'flex';
    }
});