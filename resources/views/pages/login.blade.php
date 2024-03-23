<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login</title>
    <link href="{{ asset('dist/css/styles.css') }}" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous">
    </script>

    @stack('styles')
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-danger">
        <!-- Navbar Brand-->
        <img src="{{ asset('src/assets/img/logo times.png') }}" alt="logo" style="max-height: 70% !important;">
    </nav>

    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container mt-5 mb-3">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card border-0 mt-4 ml-2">
                                <img src="{{ asset('src/assets/img/logo.png') }}" alt="logo"
                                    style="max-height: 100% !important;">
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="card border-0 rounded-lg mt-4">
                                <div class="card-header bg-white">
                                    <h3 class="font-weight-light mt-4 mb-2">Selamat Datang</h3>
                                    <h4 class="font-weight-light">Silahkan masuk menggunakan akun yang telah
                                        didaftarkan oleh Admin</h4>
                                </div>
                                <div class="card-body">

                                    @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button class="btn-close" type="button" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    @endif

                                    <form action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input class="form-control @error('email') is-invalid @enderror" id="email"
                                                name="email" type="email" placeholder="name@example.com" />
                                            <label for="email">Email address</label>
                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control @error('password') is-invalid @enderror"
                                                id="password" name="password" type="password" placeholder="Password" />
                                            <label for="password">Password</label>
                                            @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" id="inputRememberPassword" type="checkbox"
                                                value="" />
                                            <label class="form-check-label" for="inputRememberPassword">Remember
                                                Password</label>
                                        </div>
                                        <button type="submit" class="btn btn-danger w-100">Login</button>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="#">Forgot Password?</a>
                                        </div>
                                    </form>
                                </div>
                                {{-- <div class="card-footer text-center py-3">
                                    <div class="small"><a href="#">Need an account? Sign up!</a></div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-danger mt-auto">
                <div class="container-fluid px-4">
                    <div class="text-center">
                        <div class="text-white">Copyright &copy; 2024 TIMES Media.</div>
                        <div>
                            <a class="text-white text-decoration-none" href="#">All rights reserved.</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('dist/js/scripts.js') }}"></script>

    @stack('scripts')
</body>

</html>