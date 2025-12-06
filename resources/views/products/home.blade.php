@extends('layouts.app')

@section('title', 'Каталог товарів - COMFY')

@section('content')
<!-- Герой секція -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">Ласкаво просимо до каталогу товарів!</h1>
                <p class="lead mb-4">Знайдіть найкращі товари за вигідними цінами з доставкою по всій Україні</p>
                <div class="d-flex gap-2 flex-wrap">
                    <span class="badge bg-light text-dark fs-6">🚚 Безкоштовна доставка</span>
                    <span class="badge bg-light text-dark fs-6">⭐ Гарантія якості</span>
                    <span class="badge bg-light text-dark fs-6">💳 Безпечна оплата</span>
                </div>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <i class="fas fa-shopping-bag display-1 opacity-75"></i>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row">
        <!-- Бічна панель фільтрів -->
        <div class="col-lg-3 col-md-4">
            <!-- Пошук для мобільних -->
            <div class="search-box d-md-none mb-4">
                <i class="bi bi-search"></i>
                <input type="text" class="form-control" placeholder="Пошук товарів...">
            </div>

            <div class="filter-sidebar p-4 mb-4">
                <h5 class="fw-bold mb-4 text-primary">
                    <i class="bi bi-funnel me-2"></i>Фільтри
                </h5>
                
                <!-- Категорії -->
                <div class="mb-4">
                    <h6 class="fw-semibold mb-3 d-flex justify-content-between align-items-center">
                        <span>Категорії</span>
                        <span class="badge bg-primary rounded-pill">{{ $categories->count() }}</span>
                    </h6>
                    <div class="category-list">
                        @foreach($categories as $category)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="cat{{ $category->id }}">
                            <label class="form-check-label d-flex justify-content-between w-100" for="cat{{ $category->id }}">
                                <span>{{ $category->name }}</span>
                                <span class="text-muted small">({{ rand(50, 500) }})</span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Ціна -->
                <div class="mb-4">
                    <h6 class="fw-semibold mb-3">Діапазон цін, ₴</h6>
                    <div class="row g-2 mb-2">
                        <div class="col">
                            <input type="number" class="form-control" placeholder="Від" min="0" value="0">
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" placeholder="До" min="0" value="60000">
                        </div>
                    </div>
                    <button class="btn btn-comfy w-100">
                        <i class="bi bi-check-lg me-2"></i>Застосувати
                    </button>
                </div>

                <!-- Акція -->
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="discountCheck" style="transform: scale(1.2);">
                        <label class="form-check-label fw-semibold" for="discountCheck">
                            <i class="bi bi-percent me-2 text-danger"></i>Тільки акційні
                        </label>
                    </div>
                </div>

                <!-- Бренди -->
                <div class="mb-4">
                    <h6 class="fw-semibold mb-3">Бренди</h6>
                    <select class="form-select">
                        <option selected>Всі бренди</option>
                        <option>Apple</option>
                        <option>Samsung</option>
                        <option>Xiaomi</option>
                        <option>Huawei</option>
                    </select>
                </div>

                <button class="btn btn-outline-comfy w-100">
                    <i class="bi bi-arrow-clockwise me-2"></i>Скинути фільтри
                </button>
            </div>

            <!-- Банер знижки -->
            <div class="card promo-banner text-white mb-4">
                <div class="card-body text-center p-4">
                    <i class="bi bi-lightning-charge display-4 mb-3"></i>
                    <h5 class="fw-bold mb-2">ЗНИЖКИ ДО -50%</h5>
                    <p class="mb-0 opacity-90">Тільки цього тижня!</p>
                </div>
            </div>
        </div>

        <!-- Основний контент -->
        <div class="col-lg-9 col-md-8">
            <!-- Заголовок та сортування -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 p-3 bg-white rounded-3 shadow-sm">
                <div class="mb-3 mb-md-0">
                    <h2 class="h4 fw-bold mb-1 text-primary">Смартфони та телефони</h2>
                    <p class="text-muted mb-0">
                        <i class="bi bi-grid me-1"></i>
                        {{ $products->total() }}+ товарів • Сторінка {{ $products->currentPage() }}
                    </p>
                </div>
                
                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-3 w-100 w-md-auto">
                    <span class="text-muted d-none d-md-block small">
                        <i class="bi bi-info-circle me-1"></i>Авторизуйтесь для персональних цін
                    </span>
                    <select class="form-select sort-select">
                        <option>За популярністю</option>
                        <option>За ціною (від дешевих)</option>
                        <option>За ціною (від дорогих)</option>
                        <option>За новизною</option>
                        <option>За рейтингом</option>
                    </select>
                </div>
            </div>

            <!-- Сітка товарів -->
            <div class="row g-4">
                @foreach($products as $product)
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="card product-card h-100">
                        <div class="position-relative">
                            @if($product->discount)
                            <span class="discount-badge position-absolute top-0 start-0 m-2">
                                -{{ $product->discount }}%
                            </span>
                            @endif
                            <div class="product-image">
                                @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                     class="img-fluid" style="max-height: 180px; object-fit: contain;">
                                @else
                                <div class="text-center text-muted">
                                    <i class="bi bi-phone display-4"></i>
                                    <p class="small mt-2">Зображення</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="card-body d-flex flex-column p-3">
                            <!-- Категорія -->
                            <div class="mb-2">
                                <span class="category-badge">{{ $product->category->name }}</span>
                            </div>
                            
                            <!-- Назва товару -->
                            <h6 class="card-title fw-bold mb-2 line-clamp-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $product->name }}
                            </h6>
                            
                            <!-- Опис -->
                            <p class="card-text small text-muted flex-grow-1 mb-3 line-clamp-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $product->description }}
                            </p>
                            
                            <!-- Ціна та кнопки -->
                            <div class="mt-auto">
                                <!-- Ціна -->
                                @if($product->discount)
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="price-old">{{ number_format($product->price, 0, '', ' ') }} ₴</span>
                                    <span class="price-new">{{ number_format($product->price * (1 - $product->discount/100), 0, '', ' ') }} ₴</span>
                                </div>
                                @else
                                <div class="price-new mb-2">{{ number_format($product->price, 0, '', ' ') }} ₴</div>
                                @endif
                                
                                <!-- Рейтинг -->
                                <div class="d-flex align-items-center mb-3">
                                    <div class="text-warning small">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i>
                                    </div>
                                    <span class="text-muted small ms-1">({{ rand(10, 500) }})</span>
                                </div>
                                
                                <!-- Кнопки дій -->
                                <div class="d-grid gap-2">
                                    <button class="btn btn-comfy btn-sm">
                                        <i class="bi bi-cart-plus me-2"></i>В кошик
                                    </button>
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-eye me-2"></i>Детальніше
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Пагінація -->
            @if($products->hasPages())
            <div class="mt-5 d-flex justify-content-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        {{ $products->links() }}
                    </ul>
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection