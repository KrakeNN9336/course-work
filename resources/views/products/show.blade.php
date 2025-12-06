@extends('layouts.app')

@section('title', $product->name . ' - COMFY')

@section('content')
<div class="container py-5">
    
    {{-- Хлібні крихти (Навігація) --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('products.home') }}" class="text-decoration-none">Головна</a></li>
            @if($product->category)
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}?category[]={{ $product->category_id }}" class="text-decoration-none">{{ $product->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    {{-- ПОВІДОМЛЕННЯ ПРО УСПІШНИЙ ВІДГУК --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Основна інформація про товар --}}
    <div class="row mb-5">
        {{-- Ліва колонка: Зображення --}}
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="card border-0 shadow-sm">
                <div class="position-relative p-4 text-center bg-white rounded">
                    @if($product->discount)
                        <span class="discount-badge position-absolute top-0 start-0 m-3 fs-5 px-3 py-1">
                            -{{ $product->discount }}%
                        </span>
                    @endif
                    
                    @if($product->image)
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 400px; object-fit: contain;">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light rounded text-muted" style="height: 400px;">
                            <i class="bi bi-camera-fill display-1"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Права колонка: Деталі та Купівля --}}
        <div class="col-md-6">
            <div class="ps-md-4">
                <h1 class="fw-bold mb-3">{{ $product->name }}</h1>
                
                {{-- Рейтинг (Використовуємо аксесор з моделі) --}}
                <div class="d-flex align-items-center mb-3">
                    <div class="text-warning me-2">
                        @php $rating = round($product->average_rating); @endphp
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi {{ $i <= $rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                        @endfor
                    </div>
                    <span class="text-muted small">({{ $product->reviews->count() }} відгуків)</span>
                    <span class="text-muted small ms-3">Код: {{ $product->id + 10000 }}</span>
                </div>

                <div class="mb-4">
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                        <i class="bi bi-check-circle-fill me-1"></i> Є в наявності
                    </span>
                </div>

                <div class="card bg-light border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-end mb-3">
                            @if($product->discount)
                                <div class="me-3">
                                    <div class="text-muted text-decoration-line-through small">
                                        {{ number_format($product->price, 0, '', ' ') }} ₴
                                    </div>
                                    <div class="h2 fw-bold text-danger mb-0">
                                        {{ number_format($product->discounted_price, 0, '', ' ') }} ₴
                                    </div>
                                </div>
                            @else
                                <div class="h2 fw-bold text-primary mb-0">
                                    {{ number_format($product->price, 0, '', ' ') }} ₴
                                </div>
                            @endif
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('cart.add', $product->id) }}" class="btn btn-comfy btn-lg">
                                <i class="bi bi-cart-plus me-2"></i>Купити зараз
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Опис товару</h5>
                    <p class="text-muted" style="line-height: 1.8;">
                        {{ $product->description }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- БЛОК: ВІДГУКИ --}}
    <div class="row mt-5" id="reviews">
        <div class="col-lg-8">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3 class="fw-bold mb-0">Відгуки про товар</h3>
                <span class="badge bg-secondary rounded-pill">{{ $product->reviews->count() }}</span>
            </div>

            {{-- Форма додавання відгуку (Тільки для авторизованих) --}}
            @auth
                <div class="card mb-5 border-0 shadow-sm bg-light">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3 fw-bold">Залишити свій відгук</h5>
                        <form action="{{ route('products.reviews.store', $product) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Ваша оцінка:</label>
                                <div class="rating-css">
                                    @for($i = 1; $i <= 5; $i++)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rating" id="rating{{$i}}" value="{{$i}}" required>
                                            <label class="form-check-label text-warning" for="rating{{$i}}">
                                                {{ $i }} <i class="bi bi-star-fill"></i>
                                            </label>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="comment" class="form-label fw-semibold">Коментар:</label>
                                <textarea class="form-control" name="comment" id="comment" rows="3" placeholder="Поділіться своїми враженнями про товар..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-2"></i>Надіслати відгук
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-info d-flex align-items-center mb-5">
                    <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                    <div>
                        Бажаєте залишити відгук? Будь ласка, <a href="{{ route('login') }}" class="alert-link">увійдіть</a> або <a href="{{ route('register') }}" class="alert-link">зареєструйтеся</a>.
                    </div>
                </div>
            @endauth

            {{-- Список відгуків --}}
            @forelse($product->reviews as $review)
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-weight: bold;">
                                    {{ substr($review->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">{{ $review->user->name }}</h6>
                                    <div class="text-warning small">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <small class="text-muted">{{ $review->created_at->format('d.m.Y') }}</small>
                        </div>
                        <p class="card-text mt-3">{{ $review->comment }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-chat-square-text display-4 mb-3"></i>
                    <p>Ще немає відгуків. Будьте першим!</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- БЛОК: СХОЖІ ТОВАРИ --}}
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <div class="mt-5 pt-4 border-top">
        <h3 class="fw-bold mb-4">Вам також може сподобатися</h3>
        <div class="row g-4">
            @foreach($relatedProducts as $related)
            <div class="col-6 col-md-3">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        @if($related->discount)
                            <span class="discount-badge position-absolute top-0 start-0 m-2">
                                -{{ $related->discount }}%
                            </span>
                        @endif
                        <div class="product-image" style="height: 160px;">
                            @if($related->image)
                                <img src="{{ $related->image }}" alt="{{ $related->name }}" class="img-fluid" style="max-height: 140px;">
                            @else
                                <i class="bi bi-image text-muted display-6"></i>
                            @endif
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column p-3">
                        <h6 class="card-title fw-bold mb-2 text-truncate">
                            <a href="{{ route('products.show', $related->id) }}" class="text-decoration-none text-dark stretched-link">
                                {{ $related->name }}
                            </a>
                        </h6>
                        <div class="mt-auto">
                            <div class="fw-bold text-primary">
                                {{ number_format($related->discounted_price ?? $related->price, 0, '', ' ') }} ₴
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection