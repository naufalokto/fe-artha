<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup Customer</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #f0f4ff 0%, #c7d2fe 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: #fff;
            padding: 2.5rem 2rem 2rem 2rem;
            border-radius: 1.25rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }
        .login-container h2 {
            margin-bottom: 1.5rem;
            color: #2563eb;
            text-align: center;
            font-weight: 700;
        }
        .login-container label {
            margin-top: 0.75rem;
            margin-bottom: 0.25rem;
            font-weight: 500;
            color: #374151;
        }
        .login-container input[type="text"],
        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 0.6rem 0.75rem;
            border: 1px solid #cbd5e1;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 1rem;
            background: #f9fafb;
            transition: border 0.2s;
        }
        .login-container input:focus {
            border: 1.5px solid #2563eb;
            outline: none;
        }
        .login-container button[type="submit"] {
            margin-top: 1.2rem;
            width: 100%;
            padding: 0.7rem;
            background: linear-gradient(90deg, #2563eb 0%, #60a5fa 100%);
            color: #fff;
            border: none;
            border-radius: 0.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.08);
            transition: background 0.2s;
        }
        .login-container button[type="submit"]:hover {
            background: linear-gradient(90deg, #1d4ed8 0%, #3b82f6 100%);
        }
        .back-btn {
            display: inline-block;
            margin-bottom: 18px;
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: color 0.2s;
        }
        .back-btn:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }
        .login-link {
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }
        .login-link:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }
        #error-message, #success-message {
            text-align: center;
            margin-bottom: 0.5rem;
            font-size: 0.98rem;
        }
        @media (max-width: 500px) {
            .login-container {
                padding: 1.2rem 0.5rem 1.5rem 0.5rem;
                border-radius: 0.7rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <a href="/" class="back-btn">&larr; Kembali</a>
        <h2>Signup Customer</h2>
        <div id="error-message" style="color: red; display: none;"></div>
        <div id="success-message" style="color: green; display: none;"></div>
        <form id="signupForm">
            <label>First Name:</label><br>
            <input type="text" name="firstname" required><br>
            <label>Last Name:</label><br>
            <input type="text" name="lastname" required><br>
            <label>Email:</label><br>
            <input type="email" name="email" required><br>
            <label>Username:</label><br>
            <input type="text" name="username" required><br>
            <label>Password:</label><br>
            <input type="password" name="password" required><br>
            <button type="submit">Signup</button>
        </form>
        <div style="text-align:center;margin-top:18px;">
            Sudah punya akun? <a href="{{ route('login') }}" class="login-link">Login di sini</a>
        </div>
    </div>
    <script>
    document.getElementById('signupForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = {
            firstname: document.querySelector('input[name="firstname"]').value,
            lastname: document.querySelector('input[name="lastname"]').value,
            email: document.querySelector('input[name="email"]').value,
            username: document.querySelector('input[name="username"]').value,
            password: document.querySelector('input[name="password"]').value
        };
        try {
            const response = await fetch('/signup', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(formData)
            });
            const result = await response.json();
            if (response.ok) {
                document.getElementById('success-message').style.display = 'block';
                document.getElementById('success-message').textContent = 'User registered successfully with role: Customer';
                setTimeout(() => {
                    window.location.href = '/login';
                }, 2000);
            } else {
                document.getElementById('error-message').style.display = 'block';
                document.getElementById('error-message').textContent = result.message || 'Failed to register user';
            }
        } catch (error) {
            console.error('Error:', error);
            document.getElementById('error-message').style.display = 'block';
            document.getElementById('error-message').textContent = 'Terjadi kesalahan saat mendaftar';
        }
    });
    </script>
</body>
</html>