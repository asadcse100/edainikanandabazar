<!DOCTYPE html>
<html lang="en">
<head>
        <title>www.samakal.net</title>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">

        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />

        <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/login_main.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/login_responsive.css') }}">

    </head>

    <body class="login">
        <div class="main-login col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
            <div class="logo"><a href="{{url('/')}}"><img src="{{ asset('assets/images/samakal_logo_green.png') }}" alt="" class="img-responsive" width="200px" /></a></div>            
                <div class="panel panel-info">
                    <div class="panel-heading">Sign in to your account</div>
                    <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>

            <div class="login-copyright">
                <p>{{date('Y')}} &copy; Samakal. All Rights Reserved.</p>
            </div>
        </div>
    </body>
</html>