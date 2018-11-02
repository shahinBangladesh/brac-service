<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from hencework.com/theme/goofy/full-width-dark/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 24 May 2018 17:19:01 GMT -->
<head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>ESS Corporate Login Panel </title>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('image/logo.png') }}">
        <link rel="icon" href="{{ asset('image/logo.png') }}" type="image/x-icon">
        
        <!-- vector map CSS -->
        <link href="{{ asset('css/jasny-bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        
        
        
        <!-- Custom CSS -->
        <link href="{{ asset('css/theme.css') }}" rel="stylesheet" type="text/css">
    </head>
    <body>
        <!--Preloader-->
        <div class="preloader-it">
            <div class="la-anim-1"></div>
        </div>
        <!--/Preloader-->
        
        <div class="wrapper pa-0">
            <header class="sp-header">
                <div class="sp-logo-wrap pull-left">
                    <a href="{{ url('/') }}">
                        <img class="brand-img mr-10" class="img-responsive" style="width: 100px;" src="{{ asset('image/logo.png') }}" alt="brand"/>
                    </a>
                </div>
                <div class="clearfix"></div>
            </header>
            
            <!-- Main Content -->
            <div class="page-wrapper pa-0 ma-0 auth-page">
                <div class="container-fluid">
                    <!-- Row -->
                    <div class="table-struct full-width full-height">
                        <div class="table-cell vertical-align-middle auth-form-wrap">
                            <div class="auth-form  ml-auto mr-auto no-float">
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="mb-30">
                                            <h3 class="text-center txt-dark mb-10">Sign in to Corporate</h3>
                                            <h6 class="text-center nonecase-font txt-grey">Enter your details below</h6>
                                        </div>  
                                        <div class="form-wrap">
                                            <form method="POST" action="{{ route('corporate.login.submit') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label class="control-label mb-10" for="exampleInputEmail_2">Email address</label>
                                                    <input id="exampleInputEmail_2" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback">
                                                            <strong style="color: red;">{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label class="pull-left control-label mb-10" for="exampleInputpwd_2">Password</label>
                                                    <div class="clearfix"></div>
                                                    <input id="exampleInputpwd_2" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                                    @if ($errors->has('password'))
                                                        <span class="invalid-feedback">
                                                            <strong style="color: red;">{{ $errors->first('password') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary pr-10 pull-left">
                                                        <input type="checkbox" id="checkbox_2" name="remember" {{ old('remember') ? 'checked' : '' }}> <label for="checkbox_2"> Keep me logged in</label>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="form-group text-center">
                                                    <button type="submit" class="btn btn-primary  btn-rounded">sign in</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Row -->   
                </div>
                
            </div>
            <!-- /Main Content -->
        
        </div>
        <!-- /#wrapper -->
        
        <!-- JavaScript -->
        
        <!-- jQuery -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        
        <!-- Bootstrap Core JavaScript -->
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/jasny-bootstrap.min.js') }}"></script>
        
        <!-- Slimscroll JavaScript -->
        <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
        
        <!-- Init JavaScript -->
        <script src="{{ asset('js/init.js') }}"></script>
    </body>

<!-- Mirrored from hencework.com/theme/goofy/full-width-dark/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 24 May 2018 17:19:01 GMT -->
</html>
 