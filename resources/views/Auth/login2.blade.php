<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <script src="{{ asset("assets/js/plugin/webfont/webfont.min.js")}}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../assets/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
    <link rel="stylesheet" href="{{ asset("assets/css/bootstrap.min.css")}}">
	<link rel="stylesheet" href="{{ asset("assets/css/atlantis.css")}}">
</head>
<body>
    <div class="login">
        <div class="wrapper wrapper-login">
            <div class="container container-login animated fadeIn" style="display: block;">
                <h3 class="text-center">Manajemen Mesin PG Meritjan</h3>
                <form action="http://127.0.0.1:8000/login" method="POST" class="user">
                    <input type="hidden" name="_token" value="NQyjPFew2h0KHG13fuPxqu7Zk4GPAs0Q9CaN85kG" autocomplete="off">                			<div class="login-form">
                    <div class="form-group">
                        <label for="username" class="placeholder"><b>Username</b></label>
                        <input id="username" name="username" type="text" class="form-control" required="" fdprocessedid="egnqyg">
                    </div>
                    <div class="form-group">
                        <label for="password" class="placeholder"><b>Password</b></label>
                        <a href="https://themekita.com/demo-atlantis-bootstrap/livepreview/examples/demo1/login2.html#" class="link float-right">Forget Password ?</a>
                        <div class="position-relative">
                            <input id="password" name="password" type="password" class="form-control" required="" fdprocessedid="gm47x8">
                            <div class="show-password">
                                <i class="icon-eye"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-action-d-flex mb-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="rememberme">
                            <label class="custom-control-label m-0" for="rememberme">Remember Me</label>
                        </div>
                        <a href="https://themekita.com/demo-atlantis-bootstrap/livepreview/examples/demo1/login2.html#" class="btn btn-primary col-md-5 float-right mt-3 mt-sm-0 fw-bold">Sign In</a>
                    </div>
                    <div class="login-account">
                        <span class="msg">Don't have an account yet ?</span>
                        <a href="https://themekita.com/demo-atlantis-bootstrap/livepreview/examples/demo1/login2.html#" id="show-signup" class="link">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<script src="{{ asset("assets/js/core/jquery.3.2.1.min.js")}}"></script>
	<script src="{{ asset("assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js")}}"></script>
	<script src="{{ asset("assets/js/core/popper.min.js")}}"></script>
	<script src="{{ asset("assets/js/core/bootstrap.min.js")}}"></script>
	<script src="{{ asset("assets/js/atlantis.min.js")}}"></script>
</body>
</html>
