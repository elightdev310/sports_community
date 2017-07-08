@extends('sc.layouts.auth')

@section('htmlheader_title')
Sign Up
@endsection

@section('content')
<div class="register-box">
    <div class="register-box-body">

        <div class="logo-title-section text-center">
            <h2>Register</h2>
        </div>

        @include('sc.commons.success_error')

        {!! Form::open(['route'=>'user.signup.post', 'method'=>'post', 'id'=>'signup-form']) !!}
            {!! Form::hidden('_action', 'register') !!}
            <div class="form-group has-feedback">
                {!! Form::text('name', NULL, ['class'=>'form-control', 'placeholder'=>'Full name']) !!}
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                {!! Form::email('email', NULL, ['class'=>'form-control', 'placeholder'=>'Email']) !!}
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
            <div class="form-group has-feedback">
                {!! Form::text('date_birth', NULL, ['class'=>'form-control date', 'placeholder'=>'Birthday (YYYY-mm-dd)']) !!}
                <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                {!! Form::select('gender', ['male'=>'Male', 'femail'=>'Female'],
                                 NULL, ['class'=>'form-control', 'placeholder'=>'- Select gender -']); !!}
            </div>
            <div class="row">
                <div class="col-xs-12">
                    {!! Form::submit('Register', ['class'=>'btn btn-primary btn-block btn-flat']) !!}
                </div>
            </div>
        {!! Form::close() !!}

        <hr />

        <div class="text-center">
            <p>Already a member?</p>
            <a href="{{ route('user.login') }}" class="btn btn-success pl30 pr30">Log in</a>
        </div>
        
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->
@endsection

@push('scripts')
<script type="text/javascript">
$(function () {
    $('.date').datetimepicker({
      format: 'YYYY-MM-DD'
    });
});
</script>
@endpush
