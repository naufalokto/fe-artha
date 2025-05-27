<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>General Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { width: 80%; margin: 0 auto; }
        .header { background-color: #2563eb; color: white; padding: 20px; text-align: center; }
        .nav { background-color: #f1f5f9; padding: 10px; text-align: center; }
        .nav a { text-decoration: none; color: #2563eb; padding: 10px 20px; margin: 10px; border-radius: 5px; }
        .nav a:hover { background-color: #ddd; }
        .card { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .card h3 { color: #2563eb; }
        .product { display: flex; justify-content: space-between; margin-bottom: 15px; }
        .product img { width: 100px; height: 100px; object-fit: cover; margin-right: 15px; }
        .product-info { flex: 1; }
        .product button { background-color: #2563eb; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 5px; }
        .product button:hover { background-color: #3b82f6; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome to Our Product Blog</h1>
        <p>Explore our featured products!</p>
    </div>

    <div class="container">
        <div id="product-section">
            <h3>Our Products</h3>
            <div id="product-list"></div>
        </div>
    </div>

    <script>
        // Dummy Data for Products
        const products = [
            { id: 1, name: 'Minyak Goreng', price: 20000.00, description: 'Minyak kemasan 1L', image: 'https://via.placeholder.com/100' },
            { id: 2, name: 'PVC etanol', price: 25000.00, description: 'Berbahan thinner guna cat', image: 'https://via.placeholder.com/100' },
            { id: 3, name: 'Minyak Bumi', price: 12000.50, description: 'Minyak Pertamax 1L', image: 'https://via.placeholder.com/100' },
            { id: 4, name: 'Minyak PVC', price: 115000.00, description: 'Literan 1L', image: 'https://via.placeholder.com/100' },
        ];

        // Simulasi status login
        let isLoggedIn = false; // Jika false, pengguna harus signup

        // Function to show products
        function showProducts() {
            const productList = document.getElementById('product-list');
            productList.innerHTML = '';  // Clear product list before adding new items

            // Iterate through products and display them
            products.forEach(product => {
                const productDiv = document.createElement('div');
                productDiv.classList.add('product');
                productDiv.innerHTML = `
                    <img src="${product.image}" alt="${product.name}">
                    <div class="product-info">
                        <h4>${product.name}</h4>
                        <p>${product.description}</p>
                        <p><strong>$${product.price}</strong></p>
                        <button onclick="addToCart(${product.id})">Add to Cart</button>
                    </div>
                `;
                productList.appendChild(productDiv);
            });
        }

        // Function to add product to cart (with signup check)
        function addToCart(productId) {
            if (!isLoggedIn) {
                alert('Please sign up first before adding to cart.');
                window.location.href = '/signup';  // Redirect to signup page
            } else {
                const product = products.find(p => p.id === productId);
                if (product) {
                    alert(`${product.name} has been added to your cart.`);  // Placeholder for actual cart functionality
                }
            }
        }

        // Initialize products when page loads
        showProducts();
    </script>
</body>
</html>
