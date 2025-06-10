<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi Peminjaman Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body, html {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }
        
        .login-container {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .login-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('image/background.jpg') }}');
            background-size: cover;
            background-position: center;
            filter: blur(3px);
            z-index: -1;
        }
        
        .login-background::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }
        
        .login-card {
            width: 400px;
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 30px;
            z-index: 1;
        }
        
        .login-logo {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .login-logo img {
            max-width: 150px;
            height: auto;
        }
        
        .form-label {
            font-weight: 500;
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
        }
        
        .form-control:focus {
            border-color: #4285F4;
            box-shadow: 0 0 0 0.2rem rgba(66, 133, 244, 0.25);
        }
        
        .forgot-password {
            font-size: 12px;
            color: #4285F4;
            text-decoration: none;
            display: block;
            text-align: right;
            margin-top: -10px;
            margin-bottom: 20px;
        }
        
        .btn-login {
            background-color: #4285F4;
            color: white;
            border: none;
            border-radius: 30px;
            padding: 10px 0;
            font-weight: 500;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            background-color: #3367d6;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .alert {
            border-radius: 8px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-background"></div>
        
        <div class="login-card">
            <div class="login-logo">
                <img src="{{ asset('image/logo.png') }}" alt="Logo">
            </div>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        required
                    >
                </div>
                
                <a href="#" class="forgot-password">Forgot Password?</a>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-login">Login</button>
                </div>
                
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>
        </div>
    </div>
</body>
</html>
