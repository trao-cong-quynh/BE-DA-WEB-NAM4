<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Request;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        // Nếu chạy trên môi trường không phải local
        if (env('APP_ENV') !== 'local') {
            // Nếu Laravel bị proxy (như Render) thì thêm dòng này
            \URL::forceScheme('https');

            // Fix proxy headers để Laravel nhận ra HTTPS
            \Illuminate\Support\Facades\Request::setTrustedProxies(
                [Request::getClientIp()],
                Request::HEADER_X_FORWARDED_ALL
            );
        }
    }
}
