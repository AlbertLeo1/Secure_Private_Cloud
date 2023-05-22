
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Lockscreen</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition lockscreen">
<div class="lockscreen-wrapper">
    <div class="lockscreen-logo">
        <a href="/login"><b>Cloud Project</a>
    </div>
    <div class="lockscreen-name">{{auth()->user()->first_name }} {{auth()->user()->last_name }}</div>
    <div class="lockscreen-item">
        <div class="lockscreen-image"><img src="{{asset('img/profile/'.auth()->user()->image) }}" alt="User Image"></div>
        <form class="lockscreen-credentials" method="POST" action="{{ route('2fa.post') }}">
        @csrf      
        <p class="text-center">We sent code to your phone : {{ substr(auth()->user()->phone, 0, 5) . '******' . substr(auth()->user()->phone,  -2) }}</p>
        @if ($message = Session::get('success'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>{{ $message }}</strong>
                </div>
            </div>
        </div>
        @endif
        @if ($message = Session::get('error'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>{{ $message }}</strong>
                </div>
            </div>
        </div>
        @endif
            <div class="input-group">
                <input type="text" class="form-control" placeholder="password" name="code">
                <div class="input-group-append">
                    <button type="button" class="btn">
                        <i class="fas fa-arrow-right text-muted"></i>
                    </button>
                    @error('code')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
        </form>
    </div>
    <div class="help-block text-center">
        Enter the 6 digits passcode that was sent to you.<br />
        Did not receive a code <a href="{{ route('2fa.resend') }}">Click here to Resend code</a>      
    </div>
    <div class="text-center">
            <a href="/login">Or sign in as a different user</a>
    </div>
  
</div>
<!-- /.center -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
</body>
</html>
