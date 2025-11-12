<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Page Not Found — 404</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
    body {
      height: 100vh;
      margin: 0;
      font-family: 'Inter', sans-serif;
      background: radial-gradient(circle at top left, #f0f9ff, #e0f2fe, #dbeafe);
      color: #1f2937;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card {
      text-align: center;
      background: white;
      padding: 3rem;
      border-radius: 1.25rem;
      box-shadow: 0 8px 20px rgba(0,0,0,0.08);
      max-width: 480px;
      width: 90%;
    }
    h1 {
      font-size: 5rem;
      color: #3b82f6;
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
      background: #3b82f6;
      color: white;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
    }
    a:hover { background: #2563eb; }
  </style>
</head>
<body>
  <div class="card">
    <h1>404</h1>
    <h2>Page Not Found</h2>
    <p>The page you’re looking for doesn’t exist or has been moved.</p>
    <a href="<?php echo e(url('/dashboard')); ?>">Back to Home</a>
  </div>
</body>
</html><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/errors/404.blade.php ENDPATH**/ ?>