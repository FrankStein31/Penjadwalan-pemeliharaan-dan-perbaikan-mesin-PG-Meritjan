<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - PG Meritjan</title>
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700", "Montserrat:400,700"]},
            custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../assets/css/fonts.min.css']},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/atlantis.css') }}">
    <style>
        body {
            background: #fff;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            overflow: hidden;
        }

        .login-container {
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 400px;
            max-width: 90%;
            padding: 0;
            position: relative;
        }

        .login-header {
            background: #2989d8;
            color: white;
            padding: 30px 20px;
            text-align: center;
            position: relative;
        }

        .login-header::after {
            content: '';
            position: absolute;
            bottom: 15px;
            left: 0;
            width: 100%;
            height: 30px;
            background: #2989d8;
            transform: skewY(-2deg);
            z-index: 0;
        }

        .login-header h3 {
            font-weight: 800;
            margin: 0;
            font-size: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .login-header img {
            height: 70px;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
        }

        .login-body {
            padding: 40px 30px 30px;
        }

        .form-group label {
            font-weight: 500;
            color: #333;
            font-size: 0.9rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            height: auto;
            background: #f7f9fc;
            border: 1px solid #e1e5ef;
            transition: all 0.3s;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(41, 137, 216, 0.2);
            border-color: #2989d8;
            background: #fff;
        }

        .btn-primary {
            background: #2989d8;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: #1e5799;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 87, 153, 0.3);
        }

        .login-footer {
            text-align: center;
            padding: 15px 30px 25px;
            color: #666;
        }

        .show-password {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .text-create-account {
            color: #2989d8;
            font-weight: 600;
            transition: all 0.3s;
        }

        .text-create-account:hover {
            color: #1e5799;
            text-decoration: none;
        }

        .alert {
            border-radius: 8px;
        }

        .custom-control-label::before {
            border-radius: 4px;
        }

        .custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #2989d8;
        }

        .login-divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }

        .login-divider span {
            flex: 1;
            height: 1px;
            background: #e1e5ef;
        }

        .login-divider p {
            margin: 0 15px;
            color: #999;
            font-size: 0.9rem;
        }

        .social-login {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s;
        }

        .social-btn:hover {
            transform: translateY(-3px);
        }

        .social-btn.google {
            background: #ea4335;
        }

        .social-btn.facebook {
            background: #3b5998;
        }

        .social-btn.twitter {
            background: #1da1f2;
        }

        /* Animation */
        .animated {
            animation-duration: 0.8s;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fadeIn {
            animation-name: fadeIn;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card animated fadeIn">
            <div class="login-header">
                <h3>MANAJEMEN MESIN PABRIK GULA MERITJAN</h3>
            </div>
            <div class="login-body">
                <form action="{{ route('login.aksi') }}" method="POST" class="user">
                    @csrf
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="form-group">
                        <label for="user_id">Username</label>
                        <input name="user_id" type="text" class="form-control" placeholder="Masukkan username Anda">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="position-relative">
                            <input name="password" type="password" class="form-control" placeholder="Masukkan password Anda">
                            <div class="show-password">
                                <i class="icon-eye"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group d-flex justify-content-between align-items-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="rememberme">
                            <label class="custom-control-label" for="rememberme">Ingat Saya</label>
                        </div>
                        <a href="#" class="text-create-account small">Lupa Password?</a>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">MASUK</button>
                    </div>

                    <div class="login-divider">
                        <span></span>
                        <p>atau</p>
                        <span></span>
                    </div>

                    <div class="social-login">
                        <a href="#" class="social-btn google"><i class="fab fa-google"></i></a>
                        <a href="#" class="social-btn facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-btn twitter"><i class="fab fa-twitter"></i></a>
                    </div>
                </form>
            </div>

            <div class="login-footer">
                <p>Belum memiliki akun? <a class="text-create-account" href="{{ route('register') }}">Daftar Sekarang</a></p>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/atlantis.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Toggle password visibility
            $('.show-password').click(function() {
                var input = $(this).prev('input');
                var icon = $(this).find('i');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('icon-eye').addClass('icon-eye-off');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('icon-eye-off').addClass('icon-eye');
                }
            });

            // Add input focus animation
            $('.form-control').focus(function() {
                $(this).parent().addClass('focused');
            });

            $('.form-control').blur(function() {
                if ($(this).val() === '') {
                    $(this).parent().removeClass('focused');
                }
            });
        });
    </script>
</body>
</html>
