<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;

class Dashboard extends BaseDashboard
{
    protected function getHeaderActions(): array
    {
        return [
            Action::make('triggerBillingCheck')
                ->label('Scan & Kirim Tagihan Harian')
                ->icon('heroicon-o-arrow-path')
                ->color('primary')
                ->requiresConfirmation()
                ->modalHeading('Jalankan Scan Tagihan')
                ->modalDescription('Apakah Anda yakin ingin memindai semua penghuni yang jatuh tempo hari ini? Sistem akan otomatis membuat tagihan baru (jika belum ada) dan mengirim broadcast WhatsApp.')
                ->modalSubmitActionLabel('Ya, Jalankan')
                ->action(function () {
                    Artisan::call('app:check-billing');
                    
                    Notification::make()
                        ->title('Scan tagihan dan broadcast selesai dijalankan!')
                        ->success()
                        ->send();
                })
        ];
    }
}
