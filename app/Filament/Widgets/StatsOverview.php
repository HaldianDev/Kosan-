<?php

namespace App\Filament\Widgets;

use App\Models\Kamar;
use App\Models\Transaksi;
use App\Models\Penghuni;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $currentMonth = now()->format('Y-m');
        
        // Count rooms
        $totalRooms = Kamar::count();
        $occupiedRooms = Kamar::whereHas('penghunis', fn ($q) => $q->where('status_aktif', true))->count();
        $vacantRooms = $totalRooms - $occupiedRooms;

        // Financial stats
        $incomeThisMonth = Transaksi::where('status', 'Lunas')
            ->where('bulan_tagihan', $currentMonth)
            ->sum('jumlah_tagihan');

        $outstandingThisMonth = Transaksi::where('status', 'Belum Lunas')
            ->where('bulan_tagihan', $currentMonth)
            ->sum('jumlah_tagihan');

        $dueTodayCount = Penghuni::where('status_aktif', true)
            ->whereDay('tanggal_masuk', now()->day)
            ->count();

        return [
            Stat::make('Kamar Terisi', "{$occupiedRooms} / {$totalRooms}")
                ->description("{$vacantRooms} Kamar Kosong")
                ->descriptionIcon('heroicon-m-home')
                ->color($occupiedRooms === $totalRooms ? 'danger' : 'success'),
            
            Stat::make('Pemasukan Bulan Ini', 'Rp ' . number_format($incomeThisMonth, 0, ',', '.'))
                ->description('Tagihan berstatus Lunas')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
            
            Stat::make('Belum Tertagih', 'Rp ' . number_format($outstandingThisMonth, 0, ',', '.'))
                ->description('Tagihan berstatus Belum Lunas')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color($outstandingThisMonth > 0 ? 'warning' : 'success'),
        ];
    }
}
