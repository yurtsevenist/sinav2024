@extends('front.layouts.app')

@section('title', 'Gizlilik Politikası')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="text-center mb-4">Gizlilik Politikası</h1>
            
            <div class="card">
                <div class="card-body">
                    <h4>1. Kişisel Verilerin Korunması</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

                    <h4 class="mt-4">2. Bilgi Toplama ve Kullanma</h4>
                    <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

                    <h4 class="mt-4">3. Çerezler (Cookies)</h4>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>

                    <h4 class="mt-4">4. Bilgi Güvenliği</h4>
                    <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>

                    <h4 class="mt-4">5. Üçüncü Taraf Hizmetleri</h4>
                    <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident.</p>

                    <h4 class="mt-4">6. Değişiklikler</h4>
                    <p>Similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.</p>

                    <div class="alert alert-info mt-4">
                        <p class="mb-0">Son güncelleme tarihi: {{ date('d.m.Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 