@extends('front.layouts.app')

@section('title', 'İade ve Değişim')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="text-center mb-4">İade ve Değişim Koşulları</h1>
            
            <div class="card">
                <div class="card-body">
                    <h4>1. İade Süreci</h4>
                    <p>Ürünlerinizi, teslim aldığınız tarihten itibaren 14 gün içerisinde iade edebilirsiniz. İade sürecini başlatmak için müşteri hizmetlerimizle iletişime geçmeniz yeterlidir.</p>

                    <h4 class="mt-4">2. İade Koşulları</h4>
                    <p>İade edilecek ürünlerin kullanılmamış, denenmemiş ve orijinal ambalajında olması gerekmektedir. Kozmetik ürünlerde hijyen sebebiyle iade kabul edilmemektedir.</p>

                    <h4 class="mt-4">3. Değişim Süreci</h4>
                    <p>Ürün değişimi için müşteri hizmetlerimizle iletişime geçebilirsiniz. Değişim işlemleri, stok durumuna göre değerlendirilmektedir.</p>

                    <h4 class="mt-4">4. Kargo Ücreti</h4>
                    <p>Ayıplı veya yanlış gönderilen ürünlerin iade kargo ücreti firmamız tarafından karşılanmaktadır. Diğer durumlarda kargo ücreti müşteriye aittir.</p>

                    <h4 class="mt-4">5. İade Ödemesi</h4>
                    <p>İade ödemeleri, ürünün depomıza ulaşmasını takiben 3 iş günü içerisinde yapılmaktadır. Ödeme, alışverişte kullanılan ödeme yöntemine göre iade edilir.</p>

                    <div class="alert alert-info mt-4">
                        <p class="mb-0">Daha detaylı bilgi için müşteri hizmetlerimizle iletişime geçebilirsiniz.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 