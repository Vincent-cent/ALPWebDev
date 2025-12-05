<nav>
    <ul>
        <li><a href="{{ route('home') }}">Beranda</a></li>
        <li><a href="{{ route('about') }}">Lacak Pesanan</a></li>
        @auth
            <li><a href="{{ route('contact') }}">Profile</a></li>
        @endauth
        @guest
            <li><a href="{{ route('contact') }}">Login</a></li>
        @endguest
    </ul>
</nav>
