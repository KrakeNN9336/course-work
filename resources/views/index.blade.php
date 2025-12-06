@extends('layouts.app')

@section('title', 'Каталог товарів - COMFY')

@section('content')
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
        <div class="col-lg-3 col-md-4">
            <form method="GET" action="{{ url('/') }}" id="filterForm">
                <div class="search-box d-md-none mb-4">
                    <i class="bi bi-search"></i>
                    <input type="text" class="form-control" name="search" placeholder="Пошук товарів..." 
                           value="{{ request('search') }}">
                </div>

                <div class="filter-sidebar p-4 mb-4">
                    <h5 class="fw-bold mb-4 text-primary">
                        <i class="bi bi-funnel me-2"></i>Фільтри
                    </h5>
                    
                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3">Пошук</h6>
                        <input type="text" class="form-control" name="search" placeholder="Назва товару..." 
                               value="{{ request('search') }}">
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3 d-flex justify-content-between align-items-center">
                            <span>Категорії</span>
                            <span class="badge bg-primary rounded-pill">{{ $categories->count() }}</span>
                        </h6>
                        <div class="category-list">
                            @foreach($categories as $category)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="category[]" 
                                       value="{{ $category->id }}" id="cat{{ $category->id }}"
                                       {{ in_array($category->id, (array)request('category', [])) ? 'checked' : '' }}>
                                <label class="form-check-label d-flex justify-content-between w-100" for="cat{{ $category->id }}">
                                    <span>{{ $category->name }}</span>
                                    <span class="text-muted small">({{ $category->products_count ?? 0 }})</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3">Діапазон цін, ₴</h6>
                        <div class="row g-2 mb-2">
                            <div class="col">
                                <input type="number" class="form-control" name="min_price" placeholder="Від" min="0" 
                                       value="{{ request('min_price', '') }}">
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" name="max_price" placeholder="До" min="0" 
                                       value="{{ request('max_price', '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3">Сортування</h6>
                        <select class="form-select" name="sort" onchange="this.form.submit()">
                            <option value="">За популярністю</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>За ціною (від дешевих)</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>За ціною (від дорогих)</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>За новизною</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-comfy">
                            <i class="bi bi-check-lg me-2"></i>Застосувати фільтри
                        </button>
                        <a href="{{ url('/') }}" class="btn btn-outline-comfy">
                            <i class="bi bi-arrow-clockwise me-2"></i>Скинути фільтри
                        </a>
                    </div>
                </div>
            </form>

            <div class="card promo-banner text-white mb-4">
                <div class="card-body text-center p-4">
                    <i class="bi bi-lightning-charge display-4 mb-3"></i>
                    <h5 class="fw-bold mb-2">ЗНИЖКИ ДО -50%</h5>
                    <p class="mb-0 opacity-90">Тільки цього тижня!</p>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-md-8">
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 p-3 bg-white rounded-3 shadow-sm">
                <div class="mb-3 mb-md-0">
                    <h2 class="h4 fw-bold mb-1 text-primary">Всі товари</h2>
                    <p class="text-muted mb-0">
                        <i class="bi bi-grid me-1"></i>
                        {{ $products->total() }} товарів • 
                        Сторінка {{ $products->currentPage() }} з {{ $products->lastPage() }} • 
                        Показано {{ $products->count() }} товарів
                    </p>
                </div>
                
                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-3 w-100 w-md-auto">
                    <span class="text-muted d-none d-md-block small">
                        <i class="bi bi-info-circle me-1"></i>Авторизуйтесь для персональних цін
                    </span>
                </div>
            </div>

            @php
                $hasActiveFilters = request()->anyFilled(['search', 'category', 'min_price', 'max_price', 'sort']);
            @endphp
            
            @if($hasActiveFilters)
            <div class="mb-4">
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <span class="fw-semibold">Активні фільтри:</span>
                    
                    @if(request('search'))
                    @php
                        $queryWithoutSearch = request()->except('search', 'page');
                    @endphp
                    <span class="badge bg-primary">
                        Пошук: "{{ request('search') }}"
                        <a href="{{ url('/') }}?{{ http_build_query($queryWithoutSearch) }}" class="text-white ms-1">×</a>
                    </span>
                    @endif
                    
                    @if(request('category'))
                    @foreach((array)request('category') as $catId)
                        @php 
                            $category = $categories->firstWhere('id', $catId);
                            $queryWithoutCategory = request()->except('page');
                            $currentCategories = (array)request('category', []);
                            $newCategories = array_diff($currentCategories, [$catId]);
                            $queryWithoutCategory['category'] = $newCategories;
                        @endphp
                        @if($category)
                        <span class="badge bg-primary">
                            {{ $category->name }}
                            <a href="{{ url('/') }}?{{ http_build_query($queryWithoutCategory) }}" class="text-white ms-1">×</a>
                        </span>
                        @endif
                    @endforeach
                    @endif
                    
                    @if(request('min_price'))
                    @php
                        $queryWithoutMinPrice = request()->except('min_price', 'page');
                    @endphp
                    <span class="badge bg-primary">
                        Від {{ request('min_price') }} ₴
                        <a href="{{ url('/') }}?{{ http_build_query($queryWithoutMinPrice) }}" class="text-white ms-1">×</a>
                    </span>
                    @endif
                    
                    @if(request('max_price'))
                    @php
                        $queryWithoutMaxPrice = request()->except('max_price', 'page');
                    @endphp
                    <span class="badge bg-primary">
                        До {{ request('max_price') }} ₴
                        <a href="{{ url('/') }}?{{ http_build_query($queryWithoutMaxPrice) }}" class="text-white ms-1">×</a>
                    </span>
                    @endif
                    
                    @if(request('sort'))
                    @php
                        $queryWithoutSort = request()->except('sort', 'page');
                    @endphp
                    <span class="badge bg-primary">
                        Сортування
                        <a href="{{ url('/') }}?{{ http_build_query($queryWithoutSort) }}" class="text-white ms-1">×</a>
                    </span>
                    @endif
                    
                    <a href="{{ url('/') }}" class="btn btn-sm btn-outline-primary">Очистити все</a>
                </div>
            </div>
            @endif

            @if($products->count() > 0)
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
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" 
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
                            <div class="mb-2">
                                <span class="category-badge">{{ $product->category->name ?? 'Без категорії' }}</span>
                            </div>
                            
                            <h6 class="card-title fw-bold mb-2 line-clamp-2">
                                {{ $product->name }}
                            </h6>
                            
                            <p class="card-text small text-muted flex-grow-1 mb-3 line-clamp-2">
                                {{ Str::limit($product->description, 60) }}
                            </p>
                            
                            <div class="mt-auto">
                                <div class="price-new mb-2">{{ number_format($product->price, 0, '', ' ') }} ₴</div>
                                
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
                                
                                <div class="d-grid gap-2">
                                    {{-- ЗМІНА ТУТ: Посилання на додавання в кошик --}}
                                    <a href="{{ route('cart.add', $product->id) }}" class="btn btn-comfy btn-sm">
                                        <i class="bi bi-cart-plus me-2"></i>В кошик
                                    </a>
                                    
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

            <div class="mt-5">
                {{ $products->appends(request()->query())->links() }}
            </div>

            @else
            <div class="text-center py-5">
                <i class="bi bi-search display-1 text-muted"></i>
                <h3 class="text-muted mt-3">Товарів не знайдено</h3>
                <p class="text-muted">Спробуйте змінити параметри пошуку</p>
                <a href="{{ url('/') }}" class="btn btn-comfy">
                    <i class="bi bi-arrow-clockwise me-2"></i>Скинути фільтри
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Автоматичне застосування фільтрів при зміні значень
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="category[]"]');
    const numberInputs = document.querySelectorAll('input[type="number"]');
    
    // Для чекбоксів категорій
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });
    
    // Для числових полів (з затримкою)
    numberInputs.forEach(input => {
        let timeout;
        input.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 800);
        });
    });
    
    // Затримка для пошуку
    let searchTimeout;
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 500);
        });
    }
});
</script>
@endpush