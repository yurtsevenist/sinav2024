<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['site_name'] }} - @yield('title')</title>
    
    @vite(['resources/js/app.js'])
    @stack('styles')

    <!-- Custom CSS -->
    <style>
        .navbar-cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    @include('front.partials.header')

    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('front.partials.footer')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts')

    <!-- Sepet işlemleri için JavaScript -->
    <script>
        function addToCart(productId, quantity = 1) {
            $.post('/cart/add', {
                product_id: productId,
                quantity: quantity,
                _token: '{{ csrf_token() }}'
            })
            .done(function(response) {
                updateCartCount(response.cartCount);
                showAlert('Ürün sepete eklendi!', 'success');
            })
            .fail(function() {
                showAlert('Bir hata oluştu!', 'danger');
            });
        }

        function updateCartCount(count) {
            $('.cart-count').text(count);
        }

        function showAlert(message, type) {
            const alert = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            $('#alerts').html(alert);
            setTimeout(() => $('#alerts .alert').alert('close'), 3000);
        }
    </script>

    <div class="bg-primary text-white py-2 text-center">
        <p class="mb-0">{{ $settings['free_shipping_min_amount'] }} TL ve üzeri alışverişlerinizde ücretsiz kargo!</p>
    </div>
</body>
</html> 