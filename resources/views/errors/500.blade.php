<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Server Error — 500</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
    body {
      height: 100vh;
      background: radial-gradient(circle at bottom right, #fff7ed, #ffedd5, #fed7aa);
      color: #1f2937;
      font-family: 'Inter', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
    }
    .card {
      background: white;
      padding: 3rem;
      border-radius: 1.25rem;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      text-align: center;
      max-width: 480px;
      width: 90%;
    }
    h1 {
      font-size: 5rem;
      color: #f97316;
      margin: 0;
      font-weight: 700;
    }
    h2 {
      font-size: 1.6rem;
      margin: 0.5rem 0;
    }
    p {
      color: #6b7280;
      font-size: 1rem;
    }
    .loader {
      width: 50px;
      height: 50px;
      border: 4px solid #fde68a;
      border-top-color: #f97316;
      border-radius: 50%;
      margin: 1.5rem auto;
      animation: spin 1s linear infinite;
    }
    a {
      display: inline-block;
      margin-top: 1rem;
      padding: 0.6rem 1.5rem;
      background: #f97316;
      color: white;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
    }
    a:hover { background: #ea580c; }
    @keyframes spin { to { transform: rotate(360deg); } }
  </style>
</head>
<body>
  <div class="card">
    <h1>500</h1>
    <h2>Something Went Wrong</h2>
    <p>Our team has been notified and is already on it.<br>Please try again later.</p>
    <div class="loader"></div>
    <a href="{{ url('/dashboard') }}">Return Home</a>
  </div>
</body>
</html>