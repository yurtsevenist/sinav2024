@extends('front.layouts.app')

@section('title', 'Havale/EFT Bilgileri')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Sipariş Bilgileri -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Sipariş Bilgileri</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Sipariş Numarası:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $order->order_number }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Toplam Tutar:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ number_format($order->total_amount, 2) }} ₺
                        </div>
                    </div>
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Lütfen havale/EFT yaparken açıklama kısmına sipariş numaranızı yazmayı unutmayın.
                    </div>
                </div>
            </div>

            <!-- Banka Hesapları -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Banka Hesapları</h5>
                </div>
                <div class="card-body">
                    @foreach($bankAccounts as $account)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                @if($account->bank_logo)
                                <img src="{{ asset($account->bank_logo) }}" 
                                     alt="{{ $account->bank_name }}"
                                     height="40"
                                     class="me-3">
                                @endif
                                <h6 class="mb-0">{{ $account->bank_name }}</h6>
                            </div>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Hesap Sahibi</small>
                                    <strong>{{ $account->account_holder }}</strong>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Şube Kodu</small>
                                    <strong>{{ $account->branch_code }}</strong>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Hesap Numarası</small>
                                    <strong>{{ $account->account_number }}</strong>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">IBAN</small>
                                    <div class="input-group">
                                        <input type="text" 
                                               class="form-control form-control-sm" 
                                               value="{{ $account->iban }}" 
                                               readonly>
                                        <button class="btn btn-outline-primary btn-sm copy-btn" 
                                                type="button" 
                                                data-clipboard-text="{{ $account->iban }}">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="alert alert-warning mb-0">
                        <h6 class="alert-heading">Önemli Bilgiler</h6>
                        <ul class="mb-0">
                            <li>Havale/EFT işleminizi 24 saat içinde tamamlamanız gerekmektedir.</li>
                            <li>Ödemeniz kontrol edildikten sonra siparişiniz hazırlanmaya başlanacaktır.</li>
                            <li>Sipariş durumunuzu hesabınızdan takip edebilirsiniz.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('orders.show', $order) }}" class="btn btn-primary">
                    Siparişimi Görüntüle
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const clipboard = new ClipboardJS('.copy-btn');
    
    clipboard.on('success', function(e) {
        const button = e.trigger;
        const icon = button.querySelector('i');
        
        // İkon değişikliği
        icon.classList.remove('fa-copy');
        icon.classList.add('fa-check');
        
        // 2 saniye sonra eski haline dön
        setTimeout(() => {
            icon.classList.remove('fa-check');
            icon.classList.add('fa-copy');
        }, 2000);
        
        e.clearSelection();
    });
});
</script>
@endpush 