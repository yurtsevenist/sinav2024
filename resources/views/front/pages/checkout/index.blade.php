@extends('front.layouts.app')

@section('title', 'Ödeme')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                @csrf
                
                <!-- Teslimat Adresi -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Teslimat Adresi</h5>
                    </div>
                    <div class="card-body">
                        @foreach($addresses as $address)
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="shipping_address_id" 
                                id="shipping_{{ $address->id }}" value="{{ $address->id }}" 
                                {{ old('shipping_address_id') == $address->id ? 'checked' : '' }}>
                            <label class="form-check-label" for="shipping_{{ $address->id }}">
                                <strong>{{ $address->title }}</strong><br>
                                {{ $address->address }}<br>
                                {{ $address->district }}/{{ $address->city }} - {{ $address->postal_code }}
                            </label>
                        </div>
                        @endforeach
                        
                        @error('shipping_address_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        
                        <a href="{{ route('account.addresses.create') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-plus"></i> Yeni Adres Ekle
                        </a>
                    </div>
                </div>

                <!-- Fatura Adresi -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Fatura Adresi</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="same_address" checked>
                            <label class="form-check-label" for="same_address">
                                Teslimat adresi ile aynı
                            </label>
                        </div>
                        
                        <div id="billing_address_section" style="display: none;">
                            @foreach($addresses as $address)
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="billing_address_id" 
                                    id="billing_{{ $address->id }}" value="{{ $address->id }}"
                                    {{ old('billing_address_id') == $address->id ? 'checked' : '' }}>
                                <label class="form-check-label" for="billing_{{ $address->id }}">
                                    <strong>{{ $address->title }}</strong><br>
                                    {{ $address->address }}<br>
                                    {{ $address->district }}/{{ $address->city }} - {{ $address->postal_code }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        
                        @error('billing_address_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Ödeme Yöntemi -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Ödeme Yöntemi</h5>
                    </div>
                    <div class="card-body">
                        @foreach($paymentMethods as $method)
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" 
                                id="payment_{{ $method->code }}" value="{{ $method->code }}"
                                {{ old('payment_method') == $method->code ? 'checked' : '' }}>
                            <label class="form-check-label" for="payment_{{ $method->code }}">
                                <strong>{{ $method->name }}</strong>
                                @if($method->description)
                                <br><small class="text-muted">{{ $method->description }}</small>
                                @endif
                            </label>
                        </div>
                        @endforeach
                        
                        @error('payment_method')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Sipariş Notu -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Sipariş Notu</h5>
                    </div>
                    <div class="card-body">
                        <textarea name="notes" class="form-control" rows="3" 
                            placeholder="Siparişiniz ile ilgili eklemek istediğiniz notları buraya yazabilirsiniz.">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sipariş Özeti -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Sipariş Özeti</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                @foreach($cart->items as $item)
                                <tr>
                                    <td>
                                        {{ $item->product->name }}<br>
                                        <small class="text-muted">{{ $item->quantity }} adet</small>
                                    </td>
                                    <td class="text-end">{{ number_format($item->total, 2) }} ₺</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Ara Toplam</td>
                                    <td class="text-end">{{ number_format($cart->subtotal, 2) }} ₺</td>
                                </tr>
                                @if($cart->discount_amount > 0)
                                <tr>
                                    <td>İndirim</td>
                                    <td class="text-end text-danger">-{{ number_format($cart->discount_amount, 2) }} ₺</td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Kargo</td>
                                    <td class="text-end">{{ number_format($cart->shipping_cost, 2) }} ₺</td>
                                </tr>
                                <tr>
                                    <th>Toplam</th>
                                    <th class="text-end">{{ number_format($cart->total, 2) }} ₺</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="terms" id="terms" 
                            {{ old('terms') ? 'checked' : '' }}>
                        <label class="form-check-label" for="terms">
                            <a href="{{ route('pages.terms') }}" target="_blank">Mesafeli satış sözleşmesini</a> 
                            okudum ve kabul ediyorum
                        </label>
                    </div>
                    @error('terms')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <button type="submit" form="checkout-form" class="btn btn-primary w-100">
                        Siparişi Tamamla
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sameAddressCheckbox = document.getElementById('same_address');
    const billingAddressSection = document.getElementById('billing_address_section');
    const shippingAddressInputs = document.querySelectorAll('input[name="shipping_address_id"]');
    const billingAddressInputs = document.querySelectorAll('input[name="billing_address_id"]');

    function updateBillingAddress() {
        if (sameAddressCheckbox.checked) {
            billingAddressSection.style.display = 'none';
            const selectedShippingAddress = document.querySelector('input[name="shipping_address_id"]:checked');
            if (selectedShippingAddress) {
                const billingInput = document.querySelector(`input[name="billing_address_id"][value="${selectedShippingAddress.value}"]`);
                if (billingInput) billingInput.checked = true;
            }
        } else {
            billingAddressSection.style.display = 'block';
        }
    }

    sameAddressCheckbox.addEventListener('change', updateBillingAddress);
    shippingAddressInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (sameAddressCheckbox.checked) {
                const billingInput = document.querySelector(`input[name="billing_address_id"][value="${this.value}"]`);
                if (billingInput) billingInput.checked = true;
            }
        });
    });

    updateBillingAddress();
});
</script>
@endpush 