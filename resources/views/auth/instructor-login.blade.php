<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Instructor Login</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <!-- Bootstrap 5 CSS CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            body {
                font-family: 'Inter', sans-serif;
                background: #f8f9fa;
            }

            .auth-container {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .card {
                border: none;
                border-radius: 1rem;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
                padding: 2rem;
                width: 100%;
                max-width: 420px;
            }

            .form-control:focus {
                box-shadow: none;
                border-color: #6c757d;
            }

            .btn-dark:hover {
                background-color: #1a1a1a;
            }

            .illustration {
                background: linear-gradient(to right, #6a11cb, #2575fc);
                color: white;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 3rem;
                border-top-left-radius: 1rem;
                border-bottom-left-radius: 1rem;
            }

            .illustration h2 {
                font-weight: 600;
                margin-top: 1rem;
            }

            @media (max-width: 768px) {
                .split-screen {
                    flex-direction: column;
                }

                .illustration {
                    display: none;
                }
            }
        </style>
    </head>

    <body class="bg-light">

        <div class="container-fluid auth-container">
            <div class="row split-screen g-0">

                <!-- Left Side Illustration -->
                <div
                    class="col-lg-6 illustration d-none d-lg-flex flex-column justify-content-center align-items-center text-center">
                    <i class="fas fa-lock fa-5x mb-3"></i>
                    <h2>Welcome Back!</h2>
                    <p>Please login to access your account securely.</p>
                </div>

                <!-- Right Side Form -->
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <div class="card w-100 shadow-sm">
                        <div class="card-body p-0">
                            <h4 class="font-weight-bold mb-4">Login</h4>
                            <p class="text-muted mb-4">Enter your email and password to sign in</p>
                            @if (session("error"))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error:</strong> {{ session("error") }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <form method="POST" action="{{ route("dashboard.login.post") }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="Enter your email" required autofocus>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="Enter your password" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error("password")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                        <label class="form-check-label" for="remember">
                                            Remember me
                                        </label>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-dark btn-lg">Sign In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Bootstrap JS Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Add this at the end of body -->
        <script>
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' :
                '<i class="fas fa-eye-slash"></i>';
            });
        </script>
    </body>

</html>
