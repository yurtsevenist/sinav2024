<!-- Footer -->
<footer class="bg-dark text-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-3 mb-4">
                <h5 class="mb-3">İletişim</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-phone me-2"></i>
                        {{ $settings['contact_phone'] }}
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-envelope me-2"></i>
                        {{ $settings['contact_email'] }}
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        {{ $settings['contact_address'] }}
                    </li>
                </ul>
            </div>

            <div class="col-md-3 mb-4">
                <h5 class="mb-3">Kurumsal</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('about') }}" class="text-light text-decoration-none">Hakkımızda</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('contact') }}" class="text-light text-decoration-none">İletişim</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('privacy') }}" class="text-light text-decoration-none">Gizlilik Politikası</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('terms') }}" class="text-light text-decoration-none">Kullanım Koşulları</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-3 mb-4">
                <h5 class="mb-3">Müşteri Hizmetleri</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('shipping') }}" class="text-light text-decoration-none">Kargo Bilgileri</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('return') }}" class="text-light text-decoration-none">İade ve Değişim</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('help') }}" class="text-light text-decoration-none">Yardım Merkezi</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('faq') }}" class="text-light text-decoration-none">Sıkça Sorulan Sorular</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-3 mb-4">
                <h5 class="mb-3">Sosyal Medya</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ $settings['social_facebook'] }}" class="text-light text-decoration-none" target="_blank">
                            <i class="fab fa-facebook me-2"></i>
                            Facebook
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ $settings['social_twitter'] }}" class="text-light text-decoration-none" target="_blank">
                            <i class="fab fa-twitter me-2"></i>
                            Twitter
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ $settings['social_instagram'] }}" class="text-light text-decoration-none" target="_blank">
                            <i class="fab fa-instagram me-2"></i>
                            Instagram
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="my-4">

        <div class="row">
            <div class="col-md-6">
                <p class="mb-0">&copy; {{ date('Y') }} {{ $settings['site_name'] }}. Tüm hakları saklıdır.</p>
            </div>
        </div>
    </div>
</footer> 