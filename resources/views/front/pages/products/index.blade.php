@extends('front.layouts.app')

@section('title', 'Ürünler')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Filtreler -->
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Filtreler</h5>
                    <form action="{{ route('products.index') }}" method="GET">
                        <!-- Kategoriler -->
                        <div class="mb-4">
                            <h6>Kategoriler</h6>
                            @foreach($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="categories[]" 
                                           value="{{ $category->id }}"
                                           id="category{{ $category->id }}"
                                           @checked(in_array($category->id, request('categories', [])))>
                                    <label class="form-check-label" for="category{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Fiyat Aralığı -->
                        <div class="mb-4">
                            <h6>Fiyat Aralığı</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" 
                                           class="form-control" 
                                           name="min_price" 
                                           placeholder="Min"
                                           value="{{ request('min_price') }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" 
                                           class="form-control" 
                                           name="max_price" 
                                           placeholder="Max"
                                           value="{{ request('max_price') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Sıralama -->
                        <div class="mb-4">
                            <h6>Sıralama</h6>
                            <select class="form-select" name="sort">
                                <option value="">Seçiniz</option>
                                <option value="price_asc" @selected(request('sort') == 'price_asc')>
                                    Fiyat (Düşükten Yükseğe)
                                </option>
                                <option value="price_desc" @selected(request('sort') == 'price_desc')>
                                    Fiyat (Yüksekten Düşüğe)
                                </option>
                                <option value="name_asc" @selected(request('sort') == 'name_asc')>
                                    İsim (A-Z)
                                </option>
                                <option value="name_desc" @selected(request('sort') == 'name_desc')>
                                    İsim (Z-A)
                                </option>
                            </select>
                        </div>

                        <!-- Stok Durumu -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="in_stock" 
                                       value="1"
                                       id="inStock"
                                       @checked(request('in_stock'))>
                                <label class="form-check-label" for="inStock">
                                    Sadece Stokta Olanlar
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Filtrele
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Ürünler -->
        <div class="col-md-9">
            <!-- Üst Bilgi -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h4 mb-0">Ürünler</h1>
                    <small class="text-muted">{{ $products->total() }} ürün bulundu</small>
                </div>
                <div class="d-flex gap-2">
                    <div class="btn-group">
                        <button type="button" 
                                class="btn btn-outline-secondary @if(request('view', 'grid') == 'grid') active @endif"
                                onclick="window.location.href='{{ request()->fullUrlWithQuery(['view' => 'grid']) }}'">
                            <i class="fas fa-th"></i>
                        </button>
                        <button type="button" 
                                class="btn btn-outline-secondary @if(request('view') == 'list') active @endif"
                                onclick="window.location.href='{{ request()->fullUrlWithQuery(['view' => 'list']) }}'">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>

            @if($products->isEmpty())
                <div class="alert alert-info">
                    Ürün bulunamadı.
                </div>
            @else
                <!-- Grid Görünümü -->
                @if(request('view', 'grid') == 'grid')
                    <div class="row g-4">
                        @foreach($products as $product)
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <img src="{{ asset($product->defaultImage?->image_url ?? 'images/no-image.jpg') }}" 
                                         class="card-img-top" 
                                         alt="{{ $product->name }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text text-muted">
                                            {{ Str::limit($product->description, 100) }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="h5 mb-0">{{ number_format($product->price, 2) }} TL</span>
                                            @if($product->inStock())
                                                <button onclick="addToCart({{ $product->id }})" 
                                                        class="btn btn-primary">
                                                    <i class="fas fa-cart-plus"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-secondary" disabled>
                                                    Stokta Yok
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Liste Görünümü -->
                    <div class="list-group">
                        @foreach($products as $product)
                            <div class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="{{ asset($product->defaultImage?->image_url ?? 'images/no-image.jpg') }}" 
                                             class="img-fluid rounded" 
                                             alt="{{ $product->name }}">
                                    </div>
                                    <div class="col-md-7">
                                        <h5 class="mb-1">{{ $product->name }}</h5>
                                        <p class="mb-1 text-muted">
                                            {{ Str::limit($product->description, 200) }}
                                        </p>
                                        <small class="text-muted">
                                            Kategori: {{ $product->category->name }}
                                        </small>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <div class="h5 mb-3">{{ number_format($product->price, 2) }} TL</div>
                                        @if($product->inStock())
                                            <button onclick="addToCart({{ $product->id }})" 
                                                    class="btn btn-primary">
                                                <i class="fas fa-cart-plus me-2"></i>Sepete Ekle
                                            </button>
                                        @else
                                            <button class="btn btn-secondary" disabled>
                                                Stokta Yok
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Sayfalama -->
                <div class="mt-4">
                    {{ $products->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 