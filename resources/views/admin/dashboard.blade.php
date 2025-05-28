<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%);
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
        }
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .admin-header {
            background: #2563eb;
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-nav {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
        }
        .admin-nav a {
            padding: 12px 16px;
            background: white;
            color: #2563eb;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.2s;
        }
        .admin-nav a:hover {
            background: #1d4ed8;
            color: white;
        }
        .admin-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
            margin-bottom: 24px;
        }
        .admin-card h3 {
            color: #2563eb;
            margin-bottom: 16px;
            font-weight: 700;
        }
        .logout-btn {
            background: white;
            color: #dc2626;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Admin Dashboard</h1>
            <button class="logout-btn" onclick="logout()">Logout</button>
        </div>
        
        <div class="admin-nav">
            <a href="/admin/users">Manage Users</a>
            <a href="/admin/products">Products</a>
            <a href="/admin/orders">Orders</a>
            <a href="/admin/settings">Settings</a>
        </div>
        
        <div class="admin-card">
            <h3>Quick Stats</h3>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
                <div style="background: #e0e7ff; padding: 16px; border-radius: 8px;">
                    <div style="font-size: 0.9rem; color: #64748b;">Total Users</div>
                    <div style="font-size: 1.5rem; font-weight: 700; color: #2563eb;">1,234</div>
                </div>
                <div style="background: #e0f2fe; padding: 16px; border-radius: 8px;">
                    <div style="font-size: 0.9rem; color: #64748b;">New Orders</div>
                    <div style="font-size: 1.5rem; font-weight: 700; color: #0369a1;">42</div>
                </div>
                <div style="background: #ecfdf5; padding: 16px; border-radius: 8px;">
                    <div style="font-size: 0.9rem; color: #64748b;">Revenue</div>
                    <div style="font-size: 1.5rem; font-weight: 700; color: #059669;">Rp12.345.678</div>
                </div>
                <div style="background: #fef2f2; padding: 16px; border-radius: 8px;">
                    <div style="font-size: 0.9rem; color: #64748b;">Issues</div>
                    <div style="font-size: 1.5rem; font-weight: 700; color: #dc2626;">3</div>
                </div>
            </div>
        </div>
        
        <div class="admin-card">
            <h3>Recent Activity</h3>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div style="display: flex; justify-content: space-between; padding: 12px; background: #f8fafc; border-radius: 8px;">
                    <div>User registration: john.doe@example.com</div>
                    <div style="color: #64748b;">2 hours ago</div>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 12px; background: #f8fafc; border-radius: 8px;">
                    <div>New order #12345 placed</div>
                    <div style="color: #64748b;">5 hours ago</div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function logout() {
            localStorage.removeItem('token');
            window.location.href = '/login';
        }
    </script>
</body>
</html>