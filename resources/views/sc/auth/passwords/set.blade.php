@extends('sc.layouts.auth')

@section('htmlheader_title')
Set Password
@endsection

@section('content')
<div class="login-box user-password-box">
    <div class="login-box-body">
        <p class="login-box-msg">Set Password</p>
        @include('sc.commons.success_error')

        {!! Form::open(['route'=>'user.password.set.post', 'method'=>'post']) !!}
            <div class="form-group has-feedback">
                {!! Form::email('email', $email, ['class'=>'form-control', 'placeholder'=>'Email', 'readonly']) !!}
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' =>'Password']) !!}
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' =>'Retype password']) !!}
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    {!! Form::submit('Continue', ['class'=>'btn btn-primary btn-block btn-flat']) !!}
                </div><!-- /.col -->
            </div>
        {!! Form::close() !!}
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->
@endsection
