document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const productGrid = document.getElementById('product-grid');

    document.getElementById('search-btn').addEventListener('click', function() {
        searchProducts();
    });

    document.getElementById('clear-btn').addEventListener('click', function() {
        clearSearch();
    });

    function searchProducts() {
        const query = searchInput.value.toLowerCase().trim();
        const products = productGrid.getElementsByClassName('product');

        for (const product of products) {
            const productName = product.querySelector('h2').textContent.toLowerCase();
            if (productName.includes(query)) {
                product.style.display = 'flex';
            } else {
                product.style.display = 'none';
            }
        }
    }

    function clearSearch() {
        const products = productGrid.getElementsByClassName('product');

        for (const product of products) {
            product.style.display = 'flex';
        }
        searchInput.value = '';
    }
});
