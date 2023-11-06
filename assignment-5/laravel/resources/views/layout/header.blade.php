<header id="header" class="">
    <div class="container d-flex align-items-center justify-content-between">

        <a href="index.html" class="logo"><img src="{{ asset('assets/img/logo.png') }}" alt=""
                class="img-fluid"></a>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                <li><a class="nav-link scrollto {{ request()->is('work-experience') ? 'active' : '' }}" href="{{ route('work.experience') }}">Work experience</a></li>
                <li><a class="nav-link scrollto {{ request()->is('my-projects') ? 'active' : '' }}" href="{{ route('projects.list') }}">Projects</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>

    </div>
</header>
