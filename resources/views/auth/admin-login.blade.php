<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #0f0c29, #302b63, #24243e);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        .input-group:focus-within {
            box-shadow: 0 0 0 3px rgba(126, 34, 206, 0.5);
            border-color: #7e22ce;
        }

        .btn-primary {
            background: linear-gradient(135deg, #7e22ce, #a855f7);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #6b21a8, #9333ea);
        }

        .error-icon {
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            50% {
                transform: translateX(5px);
            }

            75% {
                transform: translateX(-5px);
            }

            100% {
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="glass-card rounded-2xl p-8 shadow-xl mb-6">
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <div class="rounded-full p-3 bg-purple-500/20">
                        <i class="fas fa-shield-alt text-purple-400 text-2xl"></i>
                    </div>
                </div>
                <h2 class="text-3xl font-bold text-white">Admin Panel</h2>
                <p class="text-gray-300 mt-2">Secure Login Area</p>
            </div>

            @if(session('error'))
            <div class="bg-red-500/20 border-l-4 border-red-500 text-red-200 p-4 mb-6 rounded animate-pulse error-icon">
                <div class="flex">
                    <div class="py-1">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                    </div>
                    <div>
                        <p class="font-bold">Authentication Error</p>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('console.login.post') }}" class="space-y-6">
                @csrf

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                    <div class="input-group relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" name="email" id="email" class="block w-full pl-10 pr-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg
                                      text-white placeholder-gray-400 focus:ring-2 focus:outline-none
                                      focus:ring-purple-500/50 focus:border-transparent" placeholder="you@example.com"
                            required autofocus>
                    </div>
                    @error('email')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                        <a href="#" class="text-xs text-purple-300 hover:text-purple-100 transition-colors">Forgot
                            Password?</a>
                    </div>
                    <div class="input-group relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" name="password" id="password" class="block w-full pl-10 pr-10 py-3 bg-gray-800/50 border border-gray-700 rounded-lg
                                      text-white placeholder-gray-400 focus:ring-2 focus:outline-none
                                      focus:ring-purple-500/50 focus:border-transparent" placeholder="••••••••"
                            required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer"
                            id="togglePassword">
                            <i class="fas fa-eye text-gray-400"></i>
                        </div>
                    </div>
                    @error('password')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Submit -->
                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="rounded border-gray-700 bg-gray-800 text-purple-600
                               focus:ring-purple-500/30 focus:border-purple-500">
                        <span class="ml-2 text-sm text-gray-300">Remember me</span>
                    </label>

                    <button type="submit" class="btn-primary px-6 py-3 rounded-lg text-white font-medium
                           transition-all duration-300 hover:shadow-lg hover:scale-105 focus:outline-none
                           focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        Sign In
                    </button>
                </div>
            </form>
        </div>

        <p class="text-center text-gray-500 text-sm">
            © {{ date('Y') }} Admin Panel. All rights reserved.
        </p>
    </div>

    <!-- Password Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.innerHTML = type === 'password' ?
                        '<i class="fas fa-eye text-gray-400"></i>' :
                        '<i class="fas fa-eye-slash text-gray-400"></i>';
                });
            }
        });
    </script>
</body>

</html>
