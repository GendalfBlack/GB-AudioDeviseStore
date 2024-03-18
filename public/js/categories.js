// Очікування завантаження DOM перед виконанням скрипту
document.addEventListener('DOMContentLoaded', function() {
    // Об'явлення об'єкта для зберігання кількості товарів за категоріями
    var categories = {};
    // Перебір кожного товару для підрахунку кількості товарів за категоріями
    for (var i = 0; i < products.length; i++) {
        var product = products[i];
        // Якщо категорія товару ще не існує в об'єкті категорій, створити її з значенням 0
        if (!categories[product.category_name]) {
            categories[product.category_name] = 0;
        }
        // Збільшення лічильника товарів у відповідній категорії
        categories[product.category_name]++;
    }

    // Отримання елемента списку категорій
    var categoryList = document.querySelector('.category-list');
    // Додавання кожної категорії у список
    for (var category in categories) {
        var listItem = document.createElement('li');
        var checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.value = category;
        listItem.appendChild(checkbox);
        listItem.appendChild(document.createTextNode(category + ' (' + categories[category] + ')'));
        categoryList.appendChild(listItem);
    }

    // Отримання всіх чекбоксів
    var checkboxes = document.querySelectorAll('.category-list input[type="checkbox"]');
    var productGrid = document.getElementById('product-grid');

    // Додавання обробника подій для кожного чекбокса
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var selectedCategories = [];
            // Збір вибраних категорій
            checkboxes.forEach(function(cb) {
                if (cb.checked) {
                    selectedCategories.push(cb.value);
                }
            });

            // Якщо не вибрано жодної категорії, відображаємо всі товари
            if (selectedCategories.length === 0) {
                updateProductGrid(products);
            } else {
                // Фільтруємо товари за вибраними категоріями
                var filteredProducts = products.filter(function(product) {
                    return selectedCategories.includes(product.category_name);
                });
                updateProductGrid(filteredProducts);
            }
        });
    });
});

// Функція для оновлення сітки товарів
function updateProductGrid(products) {
    var productGrid = document.getElementById('product-grid');
    productGrid.innerHTML = '';

    // Додавання кожного товару до сітки
    products.forEach(function(product) {
        var productElement = document.createElement('div');
        productElement.classList.add('product');
        productElement.innerHTML = `
            <img src='https://placehold.co/300?text=Placeholder&font=roboto' alt='Product Image Placeholder'>
            <div class='product-details'>
                <h2>${product.product_name}</h2>
                <p>Category: ${product.category_name}</p>
                <p class='product-price'>Price: $${product.price}</p>
                <div class='product-actions'>
                    <a href='${window.location.href}?action=view_product&id=${product.product_id}'>View Details</a>
                    <form action='../app/controllers/add_to_basket.php' method='POST'>
                        <input type='hidden' name='product_id' value='${product.product_id}'>
                        <input type='hidden' name='action' value='add'>
                        <button class='product-actions-form-button' type='submit'>Add to Basket</button>
                    </form>
                </div>
            </div>`;
        productGrid.appendChild(productElement);
    });
}
