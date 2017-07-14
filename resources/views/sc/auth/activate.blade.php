@extends('sc.layouts.auth')

@section('htmlheader_title')
Activate User
@endsection

@section('content')
<div class="login-box user-activation-box">
    <div class="login-box-body">
        <p class="">Let us know this email belongs to you. Enter the code in the email sent to <strong>{{$currentUser->email}}</strong></p>
        @include('sc.commons.success_error')

        {!! Form::open(['route'=>'user.activate.post', 'method'=>'post']) !!}
            <div class="form-group has-feedback">
                {!! Form::text('code', NULL, ['class'=>'form-control', 'placeholder'=>'6-dgits Code']) !!}
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div style="line-height: 32px"><a href="{{route('user.activate.send')}}">Send Email Again</a></div>
                </div>
                <div class="col-xs-6">
                    {!! Form::submit('Continue', ['class'=>'btn btn-primary btn-block btn-flat']) !!}
                </div><!-- /.col -->
            </div>
            <div class="row pt20">
                <div class="col-xs-12">
                    <a href="{{ url('/logout') }}">Log out</a>
                </div>
            </div>
        {!! Form::close() !!}
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->
@endsection
