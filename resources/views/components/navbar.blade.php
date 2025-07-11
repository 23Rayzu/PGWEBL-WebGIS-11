<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fa-solid fa-earth-asia"></i> {{ $title }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Home</a>
                        </li>
                    @endauth
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('map') }}"><i class="fa-solid fa-map"></i> Peta</a>
                        </li>
                    @endauth
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('table') }}"><i class="fa-solid fa-table"></i> Tabel</a>
                        </li>
                    @endauth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-database"></i> Data
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/api/points"target="_blank">Data
                                    Points</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/api/polylines"target="_blank">Data
                                    Polylines</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/api/polygons"target="_blank">Data
                                    Polygons</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @auth
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger"><i class="fa-solid fa-right-from-bracket"></i>
                                    Logout</button>
                            </form>
                        </li>
                    @endauth
                    @guest
                        <li class="nav-item"></li>
                        <a class="nav-link" href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket"></i>
                            Login</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
