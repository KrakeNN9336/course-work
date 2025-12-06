@extends('layouts.app')

@section('title', 'Акційні пропозиції - COMFY')

@section('content')
<!-- Герой секція для Акцій -->
<section class="hero-section bg-danger text-white mb-5" style="background: linear-gradient(135deg, #ff6b35, #e55a2b);">
    <div class="container">
        <div class="row align-items-center py-4">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3"><i class="bi bi-percent me-2"></i>Гарячі знижки!</h1>
                <p class="lead mb-0">Встигніть придбати найкращі товари за суперцінами.</p>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <i class="bi bi-fire display-1 opacity-75"></i>
            </div>
        </div>
    </div>
</section>

<div class="container pb-5">
    <!-- Заголовок -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 fw-bold mb-0 text-dark">Акційні товари</h2>
        <span class="text-muted">{{ $products->total() }} пропозицій</span>
    </div>

    @if($products->count() > 0)
    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="card product-card h-100 border-danger"> <!-- border-danger додає червону рамку -->
                <div class="position-relative">
                    {{-- Знижка завжди є на цій сторінці --}}
                    <span class="discount-badge position-absolute top-0 start-0 m-2 bg-danger">
                        -{{ $product->discount }}%
                    </span>
                    
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
                        <span class="category-badge">{{ $product->category->name ?? 'Товар' }}</span>
                    </div>
                    
                    <h6 class="card-title fw-bold mb-2 line-clamp-2">
                        {{ $product->name }}
                    </h6>
                    
                    <div class="mt-auto">
                        <!-- Стара та нова ціна -->
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="price-new text-danger">{{ number_format($product->discounted_price ?? ($product->price * (1 - $product->discount/100)), 0, '', ' ') }} ₴</div>
                            <div class="price-old small">{{ number_format($product->price, 0, '', ' ') }} ₴</div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('cart.add', $product->id) }}" class="btn btn-danger btn-sm">
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

    <!-- Пагінація -->
    <div class="mt-5">
        {{ $products->links() }}
    </div>

    @else
    <div class="text-center py-5">
        <i class="bi bi-emoji-frown display-1 text-muted"></i>
        <h3 class="text-muted mt-3">На жаль, зараз немає акційних товарів</h3>
        <a href="{{ route('products.index') }}" class="btn btn-comfy mt-3">
            Перейти до каталогу
        </a>
    </div>
    @endif
</div>
@endsection