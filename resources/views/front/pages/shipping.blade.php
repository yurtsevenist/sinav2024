@extends('front.layouts.app')

@section('title', 'Kargo Bilgileri')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Kargo Bilgileri</h1>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Kargo Ücretleri</h5>
                    <p>{{ $settings['site_name'] }} olarak, müşterilerimize en iyi kargo hizmetini sunmak için çalışıyoruz.</p>
                    
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="fas fa-truck text-primary me-2"></i>
                            <strong>Standart Teslimat:</strong> {{ $settings['shipping_price'] ?? '29.90' }} TL
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-gift text-success me-2"></i>
                            <strong>Ücretsiz Kargo:</strong> {{ $settings['free_shipping_min_amount'] ?? '500' }} TL ve üzeri siparişlerde
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Teslimat Süreleri</h5>
                    <p>Siparişleriniz, ödeme onayından sonra en geç 24 saat içinde kargoya verilir.</p>
                    
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="fas fa-clock text-warning me-2"></i>
                            <strong>Büyükşehirler:</strong> 1-3 iş günü
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-clock text-warning me-2"></i>
                            <strong>Diğer İller:</strong> 2-4 iş günü
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Kargo Takibi</h5>
                    <p>Siparişiniz kargoya verildikten sonra, size e-posta ile kargo takip numarası gönderilecektir.</p>
                    <p>Kargo takibinizi, hesabınızdan veya kargo firmasının web sitesinden yapabilirsiniz.</p>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Kargo teslimatları sadece Türkiye sınırları içerisinde yapılmaktadır.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 