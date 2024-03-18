// Очікування завантаження DOM перед виконанням скрипту
document.addEventListener('DOMContentLoaded', function() {
    // Отримання параметрів пошуку з URL
    var searchParams = new URLSearchParams(window.location.search);
    // Перевірка, чи сторінка для перегляду продукту
    var isViewProductPage = searchParams.get('action') === 'view_product';
    // Перевірка, чи сторінка для додавання товару в кошик
    var isAddToBasketPage = window.location.pathname.includes('add_to_basket.php');
    // Визначення, чи потрібно приховати контейнер пошуку
    var hideSearchContainer = isViewProductPage || isAddToBasketPage;
    // Отримання посилання на контейнер пошуку
    var searchContainer = document.getElementById('search-container');

    // Перевірка, чи потрібно приховати контейнер пошуку
    if (hideSearchContainer) {
        searchContainer.style.display = 'none'; // Приховання контейнера пошуку
    } else {
        searchContainer.style.display = 'flex'; // Відображення контейнера пошуку
    }
});
