<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>We'll Be Back Soon!</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      height: 100vh;
      width: 100%;
      font-family: 'Inter', sans-serif;
      color: #1f2937;
      display: flex;
      align-items: center;
      justify-content: center;
      background: radial-gradient(circle at top left, #f0f9ff, #e0f2fe, #dbeafe);
      background-attachment: fixed;
    }

    .card {
      background: white;
      padding: 3rem 3.5rem;
      border-radius: 1.25rem;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
      text-align: center;
      max-width: 480px;
      width: 90%;
      animation: fadeIn 0.6s ease-out;
    }

    .icon {
      font-size: 3rem;
      margin-bottom: 1rem;
      animation: bounce 2s infinite;
    }

    h1 {
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 0.75rem;
      color: #111827;
    }

    p {
      color: #4b5563;
      font-size: 1rem;
      line-height: 1.6;
      margin-bottom: 1.5rem;
    }

    .loader {
      width: 50px;
      height: 50px;
      border: 4px solid #e5e7eb;
      border-top-color: #3b82f6;
      border-radius: 50%;
      margin: 1rem auto;
      animation: spin 1s linear infinite;
    }

    footer {
      margin-top: 2rem;
      font-size: 0.875rem;
      color: #9ca3af;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    @keyframes bounce {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-5px); }
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 480px) {
      .card {
        padding: 2rem;
      }
      h1 {
        font-size: 1.5rem;
      }
    }
  </style>
</head>
<body>
  <div class="card">
    <div class="icon">🛠️</div>
    <h1>We'll Be Back Soon!</h1>
    <p>
      Our website is currently undergoing scheduled maintenance.<br>
      We’re making some improvements to serve you better.
    </p>
    <div class="loader"></div>
    <footer>Thank you for your patience — we'll be back online shortly.</footer>
  </div>
</body>
</html><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/custom/maintenance.blade.php ENDPATH**/ ?>