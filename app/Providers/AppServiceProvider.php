<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        // Tüm view'lar ile Setting modelini paylaş
        View::share('Setting', Setting::class);

        // Sık kullanılan ayarları view'lar ile paylaş
        View::composer('*', function ($view) {
            try {
                $settings = [
                    'site_name' => Setting::get('site_name', 'Laravel E-ticaret'),
                    'contact_phone' => Setting::get('contact_phone', '0850 123 4567'),
                    'contact_email' => Setting::get('contact_email', 'info@example.com'),
                    'contact_address' => Setting::get('contact_address', 'İstanbul, Türkiye'),
                    'free_shipping_min_amount' => Setting::get('free_shipping_min_amount', 250),
                    'social_facebook' => Setting::get('social_facebook', 'https://facebook.com'),
                    'social_twitter' => Setting::get('social_twitter', 'https://twitter.com'),
                    'social_instagram' => Setting::get('social_instagram', 'https://instagram.com'),
                ];
                
                $view->with('settings', $settings);
            } catch (\Exception $e) {
                $settings = [
                    'site_name' => 'Laravel E-ticaret',
                    'contact_phone' => '0850 123 4567',
                    'contact_email' => 'info@example.com',
                    'contact_address' => 'İstanbul, Türkiye',
                    'free_shipping_min_amount' => 250,
                    'social_facebook' => 'https://facebook.com',
                    'social_twitter' => 'https://twitter.com',
                    'social_instagram' => 'https://instagram.com',
                ];
                
                $view->with('settings', $settings);
            }
        });

        // Kategorileri header için paylaş
        View::composer('front.partials.header', function ($view) {
            $categories = Category::withCount('products')
                ->whereNull('parent_id')
                ->where('status', true)
                ->orderBy('order')
                ->get();
            
            $view->with('categories', $categories);
        });
    }
}
