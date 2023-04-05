<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cloud Computing System | Login Page</title>
    <link rel="icon" type="image/jpeg" href="{{asset('img/logo/ekklesia-logo.jpeg')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"> 
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.css')}}">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
    <div class="content-wrapper">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="mt-5 card col-xs-12 col-sm-10 col-md-10 col-lg-10 col-sm-offset-1 offset-md-1 offset-lg-1">
                        <div class="card-body row">
                            <div class="col-sm-5" style="background:url({{asset('img/background/genescor-bg-auth-top.png')}}) top left no-repeat; background-size: contain;">
                                <div class="brand-col" style="background:url({{asset('img/background/genescor-bg-auth.png')}}) bottom center no-repeat; background-size: contain;">
                                    <div class="headline">
                                        <div class="brand-logo mb-5"></div>
                                        <img src="{{asset('img/background/genescor-login-female-user.png')}}" class="img-fluid" style="position: relative; bottom:0px" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="card-body login-card-body">
                                    <h4 style="font-style: normal; font-weight: 500;">&nbsp;</h4>
                                    <h3 style="font-style: normal; font-weight: 600;" class="mt-3">Sign In </h3>
                                    <form action="{{ route('login') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="new_auth">Email address</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Email/Username" value="{{old('unique_id')}}">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">&nbsp;</div>
                                                </div>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="new_auth">Password</label>
                                            <div class="input-group mb-3">
                                                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">&nbsp;</div>
                                                </div>
                                                @error('password')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-7">
                                                <div class="icheck-primary">
                                                    <input type="checkbox" id="remember">
                                                    <label for="remember">Remember Me</label>
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <a href="/forgot-password" class="text-primary">Forgot Password</a>    
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block form-control">Sign In</button>
                                        </div>
                                    </form>
                                    <p class="text-center">Don't have an Account? <a class="text-primary" href="{{route('register')}}">Sign Up Here</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <aside class="control-sidebar control-sidebar-dark"></aside>
</div>
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
</body>
</html>
