<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%);
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: #fff;
            padding: 36px 32px 28px 32px;
            border-radius: 18px;
            box-shadow: 0 4px 32px rgba(59,130,246,0.10);
            width: 100%;
            max-width: 420px;
        }
        .login-container h2 {
            text-align: center;
            color: #2563eb;
            margin-bottom: 24px;
            font-weight: 800;
        }
        .form-group {
            margin-bottom: 18px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            color: #374151;
            font-weight: 600;
        }
        input {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid #dbeafe;
            border-radius: 6px;
            font-size: 1rem;
            background: #f1f5f9;
            margin-bottom: 4px;
        }
        .btn-primary {
            width: 100%;
            padding: 12px;
            background: linear-gradient(90deg, #2563eb 0%, #60a5fa 100%);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.2s;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #1d4ed8 0%, #3b82f6 100%);
        }
        #error-message {
            text-align: center;
            margin-bottom: 12px;
            font-size: 1rem;
            color: #dc2626;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <a href="/" style="display:inline-block;margin-bottom:18px;color:#2563eb;text-decoration:none;font-weight:600;font-size:1rem;">&larr; Kembali</a>
        <h2>Login</h2>
        <div id="error-message" style="display: none;"></div>
        <form id="loginForm">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn-primary">Login</button>
        </form>
        <div style="text-align:center;margin-top:18px;">
            Belum punya akun? <a href="{{ route('signup') }}" style="color:#2563eb;font-weight:600;text-decoration:none;">Daftar</a>
        </div>
    </div>
    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            document.getElementById('error-message').style.display = 'none';
            const formData = {
                email: document.getElementById('email').value,
                password: document.getElementById('password').value
            };
            try {
                const response = await fetch('/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(formData)
                });
                const data = await response.json();
                if (response.ok) {
                    localStorage.setItem('token', data.token);
                    if(data.role === 'admin') {
                        window.location.href = '/admin';
                    } else if(data.role === 'customer') {
                        window.location.href = '/customer';
                    } else {
                        window.location.href = '/';
                    }
                } else {
                    document.getElementById('error-message').style.display = 'block';
                    document.getElementById('error-message').textContent = data.message || 'Login gagal.';
                }
            } catch (err) {
                document.getElementById('error-message').style.display = 'block';
                document.getElementById('error-message').textContent = 'Gagal terhubung ke server.';
            }
        });
    </script>
</body>
</html>