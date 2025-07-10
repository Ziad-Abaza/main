<!-- resources/views/errors/500.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Internal Server Error</title>
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #111827;
        }

        .container {
            text-align: center;
            max-width: 600px;
            padding: 2rem;
        }

        .error-image {
            width: 100%;
            max-width: 300px;
            margin: 0 auto 2rem;
        }

        h1 {
            font-size: 3rem;
            color: #ef4444;
            margin-bottom: 0.5rem;
        }

        h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        p {
            color: #6b7280;
            margin-bottom: 2rem;
        }

        .btn-primary,
        .btn-secondary {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease-in-out;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.3);
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
        }

        .btn-secondary {
            background-color: transparent;
            border: 2px solid #3b82f6;
            color: #3b82f6;
        }

        .btn-secondary:hover {
            background-color: #bfdbfe;
            color: #1e40af;
            border-color: #1e40af;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="{{ asset('assets/images/500-error.svg') }}" alt="500 Error Image" class="error-image">
        <h1>500 - Internal Server Error</h1>
        <h2>Oops! Something went wrong on our end.</h2>
        <p>We're currently experiencing technical difficulties. Please try again later or contact support if the issue
            persists.</p>

        <a href="{{ url('/') }}" class="btn-primary">Go Back Home</a>
        <a href="javascript:history.back()" class="btn-secondary" style="margin-left: 1rem;">Try Again</a>
    </div>
</body>

</html>
