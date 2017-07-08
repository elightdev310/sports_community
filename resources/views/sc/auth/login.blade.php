@extends('sc.layouts.auth')

@section('htmlheader_title')
Login
@endsection

@section('content')
<div class="login-box">
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        @include('sc.commons.success_error')

        {!! Form::open(['route'=>'user.login.post', 'method'=>'post']) !!}
            <div class="form-group has-feedback">
                {!! Form::email('email', NULL, ['class'=>'form-control', 'placeholder'=>'Email']) !!}
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' =>'Password']) !!}
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="">
                <div class="checkbox icheck">
                    <label style="margin-left: 0px;">
                        {!! Form::checkbox('remember', 'value') !!}
                        &nbsp;Remember Me
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    {!! Form::submit('Sign In', ['class'=>'btn btn-primary btn-block btn-flat']) !!}
                    <p class="pt20">Sign up for an account <a href="{{ route('user.signup') }}" class="signup-link">here.</a></p>
                </div><!-- /.col -->
            </div>
        {!! Form::close() !!}

        @include('auth.partials.social_login')

        <a href="{{ url('/password/reset') }}">I forgot my password</a><br>
        
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->
@endsection
