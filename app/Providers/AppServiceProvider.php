<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Jalankan hanya ketika aplikasi berjalan di Vercel
        if (isset($_ENV['VERCEL_JOB_ID']) || isset($_ENV['NOW_REGION'])) {
            // 1. View cache → /tmp
            $viewStorage = '/tmp/storage/framework/views';
            if (!is_dir($viewStorage)) {
                mkdir($viewStorage, 0755, true);
            }
            config(['view.compiled' => $viewStorage]);

            // 2. Livewire manifest → /tmp
            $livewireCache = '/tmp/storage/livewire';
            if (!is_dir($livewireCache)) {
                mkdir($livewireCache, 0755, true);
            }
            config(['livewire.manifest_path' => $livewireCache . '/livewire-components.php']);

            // 3. Session & cache use non‑file drivers
            config(['session.driver' => 'cookie']);
            config(['cache.default' => 'array']);

            // 4. (Optional) SQLite database file in /tmp
            $sqlitePath = '/tmp/database.sqlite';
            if (!file_exists($sqlitePath)) {
                touch($sqlitePath);
                chmod($sqlitePath, 0666);
            }
        }
    }
}
