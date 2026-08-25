<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - Bali Ride</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    /* Reset CSS dasar */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background-color: #f8f9fa; /* Latar belakang tidak diubah */
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .brand-title {
      color: #000000; /* Warna hitam standar */
      font-weight: 800;
      letter-spacing: 1px;
      margin-bottom: 2rem;
      font-size: 2.2rem;
      text-transform: uppercase;
      text-align: center;
    }

    .login-card {
      background-color: #ffffff;
      width: 100%;
      max-width: 450px;
      border-radius: 12px;
      padding: 2.5rem;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .login-header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .login-header h1 {
      font-size: 1.75rem;
      font-weight: 700;
      color: #000000; /* Warna hitam standar */
      margin-bottom: 0.5rem;
    }

    .login-header p {
      color: #000000; /* Warna hitam standar */
      opacity: 0.7; /* Sedikit transparan agar bisa dibedakan dengan judul */
      font-size: 0.95rem;
    }

    .alert-danger {
      background-color: #f8d7da;
      color: #842029;
      border: 1px solid #f5c2c7;
      padding: 0.75rem;
      border-radius: 6px;
      margin-bottom: 1.5rem;
      font-size: 0.875rem;
      text-align: center;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-label {
      display: block;
      font-size: 0.95rem;
      color: #000000; /* Warna hitam standar */
      font-weight: 500;
      margin-bottom: 0.5rem;
    }

    .form-control {
      width: 100%;
      border-radius: 6px;
      padding: 0.6rem 1rem;
      border: 1px solid #d1d5db;
      font-size: 1rem;
      font-family: inherit;
      transition: all 0.3s ease;
      color: #000000;
    }

    .form-control:focus {
      outline: none;
      border-color: #000000; /* Fokus border menjadi hitam */
      box-shadow: 0 0 0 4px rgba(0, 0, 0, 0.15); /* Efek bayangan hitam saat fokus */
    }

    .form-control::placeholder {
      color: #9ca3af;
    }

    .button-container {
      display: flex;
      justify-content: flex-end;
      margin-top: 1rem;
    }

    .btn-login {
      background-color: #000000; /* Background hitam standar */
      color: #ffffff; /* Teks putih agar terlihat jelas di tombol hitam */
      font-weight: 600;
      padding: 0.6rem 2rem;
      border: none;
      border-radius: 6px;
      font-size: 0.9rem;
      letter-spacing: 0.5px;
      cursor: pointer;
      transition: background-color 0.3s;
      font-family: inherit;
    }

    .btn-login:hover {
      background-color: #333333; /* Hitam sedikit lebih terang saat di-hover */
      color: #ffffff;
    }

    @media (max-width: 576px) {
      body {
        padding: 1.25rem;
      }

      .brand-title {
        font-size: 1.6rem;
        margin-bottom: 1.25rem;
      }

      .login-card {
        padding: 1.5rem 1rem;
      }

      .login-header h1 {
        font-size: 1.4rem;
      }
    }
  </style>
</head>
<body>
  
  <h1 class="brand-title">BALI RIDE</h1>
  
  <div class="login-card">
    <div class="login-header">
      <h1>Admin Panel</h1>
      <p>Silakan masuk untuk mengelola sistem</p>
    </div>
    
    @if ($errors->any())
      <div class="alert-danger">
        {{ $errors->first() }}
      </div>
    @endif

    <form action="/login" method="POST">
      @csrf
      
      <div class="form-group">
        <label for="username" class="form-label">Username</label>
        <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username" required autocomplete="off">
      </div>
      
      <div class="form-group">
        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
      </div>
      
      <div class="button-container">
        <button type="submit" class="btn-login">Masuk</button>
      </div>
    </form>
  </div>

</body>
</html>