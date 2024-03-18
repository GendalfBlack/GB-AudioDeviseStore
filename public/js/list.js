// Очікування завантаження DOM перед виконанням скрипту
document.addEventListener('DOMContentLoaded', function() {
    // Отримання посилання на поле введення пошуку та сітку продуктів
    const searchInput = document.getElementById('search-input');
    const productGrid = document.getElementById('product-grid');

    // Додавання обробника події для кнопки пошуку
    document.getElementById('search-btn').addEventListener('click', function() {
        searchProducts(); // Виклик функції пошуку
    });

    // Додавання обробника події для кнопки очищення пошуку
    document.getElementById('clear-btn').addEventListener('click', function() {
        clearSearch(); // Виклик функції очищення пошуку
    });

    // Функція для пошуку продуктів
    function searchProducts() {
        const query = searchInput.value.toLowerCase().trim(); // Отримання значення запиту
        const products = productGrid.getElementsByClassName('product'); // Отримання всіх продуктів зі сітки

        // Ітерація через кожен продукт
        for (const product of products) {
            const productName = product.querySelector('h2').textContent.toLowerCase(); // Отримання імені продукту
            // Перевірка, чи входить ім'я продукту в запит
            if (productName.includes(query)) {
                product.style.display = 'flex'; // Показуємо продукт, якщо ім'я відповідає запиту
            } else {
                product.style.display = 'none'; // Приховуємо продукт, якщо ім'я не відповідає запиту
            }
        }
    }

    // Функція для очищення пошуку
    function clearSearch() {
        const products = productGrid.getElementsByClassName('product'); // Отримання всіх продуктів зі сітки

        // Ітерація через кожен продукт та відображення його
        for (const product of products) {
            product.style.display = 'flex';
        }
        searchInput.value = ''; // Очищення поля введення пошуку
    }
});

