Dear {{ $user->name }},<br><br>

You have been registered on {{ url('/') }}.<br><br>

We send you activation code to activate your account.
<strong>{{ $code }}</strong><br><br>

You can login on <a href="{{ url('/login') }}">{{ str_replace("http://", "", url('/login')) }}</a>.<br><br>

Best Regards,
