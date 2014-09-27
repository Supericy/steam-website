@if(!isset($displayLoginMethod['Google']) || $displayLoginMethod['Google'])
    <a href="{{ URL::action('login.oauth', ['provider' => 'google']) }}">
        {{ HTML::image('images/social/FreeModernSocialMediaIconPack/RoundedSquares/32x32/GooglePlus.png') }}
    </a>
@endif