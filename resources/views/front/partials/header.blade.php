<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('home') }}">
                {{ $settings['site_name'] }}
            </a>

            <!-- Mobil Menü Butonu -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menü -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Ana Menü -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Anasayfa</a>
                    </li>
                    
                    <!-- Kategoriler Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            Kategoriler
                        </a>
                        <ul class="dropdown-menu">
                            @foreach($categories as $category)
                            <li>
                                <a class="dropdown-item" href="{{ route('products.category', $category->slug) }}">
                                    {{ $category->name }}
                                    <small class="text-muted">({{ $category->products_count }})</small>
                                </a>
                            </li>
                            @endforeach
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('products.index') }}">
                                    Tüm Ürünler
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- Arama Formu -->
                <form action="{{ route('products.search') }}" class="d-flex me-3">
                    <div class="input-group">
                        <input type="search" 
                               name="q" 
                               class="form-control" 
                               placeholder="Ürün ara..."
                               value="{{ request('q') }}">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                <!-- Sağ Menü -->
                <ul class="navbar-nav">
                    <!-- Sepet -->
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-count navbar-cart-count">0</span>
                        </a>
                    </li>

                    <!-- Kullanıcı -->
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i>
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="fas fa-user-circle me-2"></i>Profilim
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('orders.index') }}">
                                    <i class="fas fa-box me-2"></i>Siparişlerim
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('addresses.index') }}">
                                    <i class="fas fa-map-marker-alt me-2"></i>Adreslerim
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Çıkış Yap
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Giriş Yap
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus"></i> Kayıt Ol
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Alerts -->
    <div id="alerts" class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>
</header> 