<div class="social-auth-links text-center">
    <p>- OR -</p>
    <a href="{{ url('/auth/facebook') }}" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
    <a href="{{ url('/auth/google') }}" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
</div>

@push('scripts')
<script>
$(function () {
    $(document).ready(function() {
        $('.social-auth-links .btn-social').on('click', function(e) {
            var _width = $(window).width();
            var _height = $(window).height();
            var pos_x, pos_y;
            pos_x = (_width  - 480) / 2;
            pos_y = 100; //(_height - 320) / 2;

            var _url = $(this).attr('href');
            signinWin = window.open(_url, "SignIn", "width=480,height=320,toolbar=0,scrollbars=0,status=0,resizable=0,location=0,menuBar=0,left=" + pos_x + ",top=" + pos_y);
            signinWin.focus();
            return false;
        });
    });
});

</script>
@endpush
