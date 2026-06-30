<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        if (isset($_ENV['VERCEL_JOB_ID']) || isset($_ENV['NOW_REGION'])) {
            // 1. Alihkan compile view Blade ke /tmp
            $viewStorage = '/tmp/storage/framework/views';
            if (!is_dir($viewStorage)) {
                mkdir($viewStorage, 0755, true);
            }
            config(['view.compiled' => $viewStorage]);

            // 2. Alihkan manifest cache Livewire (wajib untuk Filament)
            $livewireCache = '/tmp/storage/livewire';
            if (!is_dir($livewireCache)) {
                mkdir($livewireCache, 0755, true);
            }
            config(['livewire.manifest_path' => $livewireCache . '/livewire-components.php']);
            
            // 3. Paksa session dan cache tidak menggunakan file lokal
            config(['session.driver' => 'cookie']);
            config(['cache.default' => 'array']);
        }
    }
}
