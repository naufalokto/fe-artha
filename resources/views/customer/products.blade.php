<!DOCTYPE html>
<html>
<head>
    <title>E-Commerce Products</title>
</head>
<body>
    <h1>Welcome Customer</h1>
    <div id="products-list">
        <!-- Daftar produk akan ditampilkan di sini -->
    </div>
    <script>
        // Ambil token dari localStorage
        const token = localStorage.getItem('token');
        
        // Fetch products dari API
        fetch('/api/products', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
        .then(response => response.json())
        .then(products => {
            // Render products
        });
    </script>
</body>
</html>