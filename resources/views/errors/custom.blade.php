<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>حدث خطأ</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body
    class="bg-gradient-to-br from-gray-900 via-purple-950 to-black text-white min-h-screen flex items-center justify-center p-4">
    <div class="glass-card rounded-3xl shadow-2xl max-w-xl w-full p-8 text-center">
        <div class="mb-6">
            @php
            $icons = [
            404 => 'fa-exclamation-triangle',
            403 => 'fa-lock',
            413 => 'fa-file-excel',
            409 => 'fa-exclamation-circle',
            'unauthorized' => 'fa-user-shield',
            'default' => 'fa-bug',
            ];

            $iconClass = $icons[$code] ?? $icons['default'];
            @endphp

            <i class="fas {{ $iconClass }} text-8xl text-indigo-500 mb-4"></i>
            <h1 class="text-6xl font-bold mb-2">{{ $code }}</h1>
            <h2 class="text-2xl font-semibold mb-4 text-gray-300">{{ $title ?? 'حدث خطأ' }}</h2>
            <p class="text-gray-400 mb-6">{{ $message ?? 'عذراً، حدث خطأ أثناء معالجة طلبك.' }}</p>
        </div>

        <a href="{{ url('/') }}"
            class="inline-block px-6 py-3 rounded-full bg-indigo-600 hover:bg-indigo-500 transition text-white font-semibold shadow-lg">
            العودة للصفحة الرئيسية
        </a>
    </div>
</body>

</html>
