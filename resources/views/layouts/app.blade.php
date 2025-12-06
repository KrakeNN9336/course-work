<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'COMFY'))</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,500,600,700,800" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #2c5aa0;
            --primary-dark: #1e3a8a;
            --secondary: #ff6b35;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #28a745;
            --border: #dee2e6;
            --shadow: 0 4px 12px rgba(0,0,0,0.08);
            --shadow-hover: 0 8px 25px rgba(0,0,0,0.15);
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f5f7fa;
            color: var(--dark);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary) !important;
        }

        .nav-link {
            font-weight: 600;
            transition: color 0.3s;
            white-space: nowrap; /* Забороняємо перенос тексту */
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        .btn-comfy {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .btn-comfy:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
            color: white;
        }

        .btn-outline-comfy {
            border: 2px solid var(--primary);
            color: var(--primary);
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .btn-outline-comfy:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .filter-sidebar {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow);
            border: none;
        }

        .product-card {
            background: white;
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover);
        }

        .product-image {
            height: 200px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .product-image img {
            transition: transform 0.3s;
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .discount-badge {
            background: linear-gradient(135deg, var(--secondary), #e55a2b);
            color: white;
            font-weight: 700;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            z-index: 2;
        }

        .price-old {
            text-decoration: line-through;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .price-new {
            color: var(--secondary);
            font-weight: 800;
            font-size: 1.2rem;
        }

        .category-badge {
            background: rgba(44, 90, 160, 0.1);
            color: var(--primary);
            font-weight: 600;
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 20px 20px;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .promo-banner {
            background: linear-gradient(135deg, #ffd700, #ff6b35);
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }

        .promo-banner h5 {
            font-weight: 800;
            margin: 0;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding-left: 2.5rem;
            border-radius: 25px;
            border: 2px solid var(--border);
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .sort-select {
            border-radius: 25px;
            border: 2px solid var(--border);
            padding: 0.375rem 2.25rem 0.375rem 0.75rem;
        }

        .pagination .page-link {
            border-radius: 8px;
            margin: 0 2px;
            border: none;
            color: var(--dark);
        }

        .pagination .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 2rem 0;
                border-radius: 0 0 15px 15px;
            }
            
            .product-card {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <i class="fas fa-store me-2"></i>
                    COMFY
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarContent">
                    <!-- Ліва частина меню (Каталог, Акції...) -->
                    <!-- me-auto штовхає все інше вправо -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('/') }}">
                                <i class="bi bi-grid me-1"></i>Каталог
                            </a>
                        </li>
                        <li class="nav-item">
                            <!-- ЗМІНЕНО: Посилання на сторінку акцій -->
                            <a class="nav-link" href="{{ route('products.offers') }}">
                                <i class="bi bi-percent me-1"></i>Акції
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-truck me-1"></i>Доставка
                            </a>
                        </li>
                    </ul>

                    <!-- Права частина меню (Пошук, Кошик, Авторизація) -->
                    <!-- d-flex тримає їх в один рядок -->
                    <div class="d-flex align-items-center gap-3">
                        
                        <!-- Пошук -->
                        <div class="search-box d-none d-md-block">
                            <i class="bi bi-search"></i>
                            <input type="text" class="form-control" placeholder="Пошук товарів..." style="width: 250px;">
                        </div>

                        <!-- Кошик (Виправлено посилання та лічильник) -->
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-comfy position-relative">
                            <i class="bi bi-cart3"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ count(session('cart', [])) }}
                            </span>
                        </a>

                        <!-- Авторизація -->
                        <ul class="navbar-nav mb-0">
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">
                                            <i class="bi bi-box-arrow-in-right me-1"></i>Увійти
                                        </a>
                                    </li>
                                @endif
                                
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">
                                            <i class="bi bi-person-plus-fill me-1"></i>Реєстрація
                                        </a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-person-circle me-2"></i>
                                        {{ Auth::user()->name }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        @if(Auth::user()->role === 'admin')
                                            <a class="dropdown-item" href="{{ route('admin.index') }}">
                                                <i class="bi bi-speedometer2 me-2"></i>Адмін-панель
                                            </a>
                                            <div class="dropdown-divider"></div>
                                        @endif
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bi bi-box-arrow-right me-2"></i>Вийти
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Анімація для карток товарів
        document.addEventListener('DOMContentLoaded', function() {
            const productCards = document.querySelectorAll('.product-card');
            
            productCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Фільтрація за ціною
            const priceInputs = document.querySelectorAll('input[type="number"]');
            priceInputs.forEach(input => {
                input.addEventListener('change', function() {
                    // Тут буде логіка фільтрації
                    console.log('Фільтр оновлено');
                });
            });
        });
    </script>
</body>
</html>