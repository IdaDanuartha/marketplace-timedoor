<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Access Denied — 403</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
    body {
      background: radial-gradient(circle at top right, #fef2f2, #fee2e2, #fecaca);
      color: #1f2937;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      font-family: 'Inter', sans-serif;
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
      color: #ef4444;
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
    a {
      display: inline-block;
      margin-top: 1.5rem;
      padding: 0.6rem 1.5rem;
      background: #ef4444;
      color: white;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
    }
    a:hover { background: #dc2626; }
  </style>
</head>
<body>
  <div class="card">
    <h1>403</h1>
    <h2>Access Denied</h2>
    <p>You don’t have permission to access this page.<br>Contact an administrator if you believe this is an error.</p>
    <a href="{{ url('/dashboard') }}">Go Home</a>
  </div>
</body>
</html>