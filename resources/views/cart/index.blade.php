@extends('layouts.app')

@section('title', 'Кошик')

@section('content')
<div class="container py-5">
    <h2 class="mb-4"><i class="bi bi-cart3 me-2"></i>Ваш кошик</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('cart') && count(session('cart')) > 0)
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col" class="border-0 p-3">Товар</th>
                                        <th scope="col" class="border-0 p-3">Ціна</th>
                                        <th scope="col" class="border-0 p-3">Кількість</th>
                                        <th scope="col" class="border-0 p-3">Сума</th>
                                        <th scope="col" class="border-0 p-3">Дії</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(session('cart') as $id => $details)
                                        <tr data-id="{{ $id }}">
                                            <td class="p-3">
                                                <div class="d-flex align-items-center">
                                                    @if($details['image'])
                                                        <img src="{{ $details['image'] }}" alt="{{ $details['name'] }}" class="rounded me-3" style="width: 60px; height: 60px; object-fit: contain;">
                                                    @else
                                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 60px;">
                                                            <i class="bi bi-image"></i>
                                                        </div>
                                                    @endif
                                                    <span class="fw-semibold">{{ $details['name'] }}</span>
                                                </div>
                                            </td>
                                            <td class="p-3">{{ number_format($details['price'], 0, '', ' ') }} ₴</td>
                                            <td class="p-3" style="width: 150px;">
                                                <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity update-cart" min="1" onchange="updateCart({{ $id }}, this.value)">
                                            </td>
                                            <td class="p-3 fw-bold text-primary">
                                                {{ number_format($details['price'] * $details['quantity'], 0, '', ' ') }} ₴
                                            </td>
                                            <td class="p-3">
                                                <form action="{{ route('cart.remove') }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $id }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Видалити товар?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mb-4">
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Продовжити покупки
                    </a>
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-danger" onclick="return confirm('Очистити весь кошик?')">
                            <i class="bi bi-trash me-2"></i>Очистити кошик
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white p-3">
                        <h5 class="mb-0 fw-bold">Підсумок замовлення</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Вартість товарів:</span>
                            <span class="fw-bold">{{ number_format($total, 0, '', ' ') }} ₴</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted">Доставка:</span>
                            <span class="text-success fw-bold">Безкоштовно</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5 fw-bold">До сплати:</span>
                            <span class="h4 fw-bold text-primary">{{ number_format($total, 0, '', ' ') }} ₴</span>
                        </div>
                        <button class="btn btn-comfy w-100 py-2 fs-5">
                            Оформити замовлення
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-cart-x display-1 text-muted opacity-50"></i>
            <h3 class="mt-3 text-muted">Ваш кошик порожній</h3>
            <p class="text-muted mb-4">Але це ніколи не пізно виправити!</p>
            <a href="{{ url('/') }}" class="btn btn-comfy btn-lg">
                <i class="bi bi-cart-plus me-2"></i>Перейти до покупок
            </a>
        </div>
    @endif
</div>

<script>
    function updateCart(id, quantity) {
        fetch('{{ route('cart.update') }}', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: id, quantity: quantity })
        }).then(response => {
            window.location.reload();
        });
    }
</script>
@endsection