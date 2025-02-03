@extends('front.layouts.app')

@section('title', 'Sepetim')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Sepetim</h1>

    @if($cart->isEmpty())
        <div class="alert alert-info">
            Sepetinizde ürün bulunmamaktadır.
            <a href="{{ route('products.index') }}" class="alert-link">
                Alışverişe başlamak için tıklayın.
            </a>
        </div>
    @else
        <div class="row">
            <!-- Sepet Ürünleri -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Ürün</th>
                                        <th>Fiyat</th>
                                        <th>Adet</th>
                                        <th>Toplam</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart->items as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset($item->product->defaultImage?->image_url ?? 'images/no-image.jpg') }}" 
                                                         alt="{{ $item->product->name }}"
                                                         class="img-thumbnail me-3"
                                                         style="width: 64px;">
                                                    <div>
                                                        <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                        <small class="text-muted">
                                                            Ürün Kodu: {{ $item->product->sku }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ number_format($item->price, 2) }} TL</td>
                                            <td style="width: 150px;">
                                                <div class="input-group">
                                                    <button class="btn btn-outline-secondary" 
                                                            type="button"
                                                            onclick="updateCartQuantity({{ $item->product->id }}, -1)">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="number" 
                                                           class="form-control text-center" 
                                                           value="{{ $item->quantity }}"
                                                           min="1"
                                                           max="{{ $item->product->stock_quantity }}"
                                                           onchange="updateCartQuantity({{ $item->product->id }}, this.value - {{ $item->quantity }})">
                                                    <button class="btn btn-outline-secondary" 
                                                            type="button"
                                                            onclick="updateCartQuantity({{ $item->product->id }}, 1)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td>{{ number_format($item->total, 2) }} TL</td>
                                            <td>
                                                <button onclick="removeFromCart({{ $item->product->id }})" 
                                                        class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sepet Özeti -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Sipariş Özeti</h5>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Ara Toplam</span>
                            <span>{{ number_format($cart->subtotal, 2) }} TL</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Kargo</span>
                            <span>{{ number_format($cart->shipping_cost, 2) }} TL</span>
                        </div>

                        @if($cart->discount_amount > 0)
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>İndirim</span>
                                <span>-{{ number_format($cart->discount_amount, 2) }} TL</span>
                            </div>
                        @endif

                        <hr>

                        <div class="d-flex justify-content-between mb-4">
                            <strong>Toplam</strong>
                            <strong>{{ number_format($cart->total, 2) }} TL</strong>
                        </div>

                        <!-- İndirim Kuponu -->
                        <div class="mb-4">
                            <form action="{{ route('cart.apply-coupon') }}" method="POST" class="input-group">
                                @csrf
                                <input type="text" 
                                       class="form-control" 
                                       name="coupon_code"
                                       placeholder="İndirim Kuponu"
                                       value="{{ session('coupon_code') }}">
                                <button class="btn btn-outline-secondary" type="submit">
                                    Uygula
                                </button>
                            </form>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100">
                            Ödemeye Geç
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function updateCartQuantity(productId, change) {
        const currentQuantity = parseInt($(`input[data-product-id="${productId}"]`).val());
        const newQuantity = currentQuantity + change;

        $.post('/cart/update', {
            product_id: productId,
            quantity: newQuantity,
            _token: '{{ csrf_token() }}'
        })
        .done(function(response) {
            location.reload();
        })
        .fail(function() {
            showAlert('Bir hata oluştu!', 'danger');
        });
    }

    function removeFromCart(productId) {
        if (confirm('Bu ürünü sepetten kaldırmak istediğinize emin misiniz?')) {
            $.post('/cart/remove', {
                product_id: productId,
                _token: '{{ csrf_token() }}'
            })
            .done(function(response) {
                location.reload();
            })
            .fail(function() {
                showAlert('Bir hata oluştu!', 'danger');
            });
        }
    }
</script>
@endpush 