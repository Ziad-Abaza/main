<!-- resources/views/errors/405.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>405 - Method Not Allowed</title>
    @vite('resources/css/app.css')
    @include('partials.error-styles')
</head>

<body>
    <div class="container">
        {{-- <img src="{{ asset('assets/images/405-method-not-allowed.svg') }}" alt="405 Method Not Allowed"
            class="error-image"> --}}
        <h1>405 - Method Not Allowed</h1>
        <h2>This request method is not supported for the requested resource.</h2>
        <p>You tried to access a resource using an HTTP method that isn’t allowed. Please check your request and try
            again.</p>

        <a href="{{ url('/') }}" class="btn-primary">Go Back Home</a>
        <a href="javascript:history.back()" class="btn-secondary" style="margin-left: 1rem;">Go Back</a>
    </div>
</body>

</html>
