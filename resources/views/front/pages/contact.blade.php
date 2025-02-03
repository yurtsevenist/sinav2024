@extends('front.layouts.app')

@section('title', 'İletişim')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="text-center mb-4">İletişim</h1>
            
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-envelope fa-2x mb-3 text-primary"></i>
                            <h5>E-posta</h5>
                            <p class="mb-0">{{ $settings['contact_email'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-phone fa-2x mb-3 text-primary"></i>
                            <h5>Telefon</h5>
                            <p class="mb-0">{{ $settings['contact_phone'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-map-marker-alt fa-2x mb-3 text-primary"></i>
                            <h5>Adres</h5>
                            <p class="mb-0">İstanbul, Türkiye</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Bize Ulaşın</h4>

                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Adınız Soyadınız</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">E-posta Adresiniz</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mesajınız</label>
                            <textarea name="message" rows="5" class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                            @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Mesaj Gönder
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 