@extends('layouts.app')

@section('title', 'Адмін-панель')

@section('content')
<div class="container">
    <h1 class="mb-4">Адмін-панель</h1>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Управління товарами</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Керування товарами магазину</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('products.create') }}" class="btn btn-primary">Додати товар</a>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Переглянути товари</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Управління категоріями</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Керування категоріями товарів</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('categories.create') }}" class="btn btn-success">Додати категорію</a>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Переглянути категорії</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection