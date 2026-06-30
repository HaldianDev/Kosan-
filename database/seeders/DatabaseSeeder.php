<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Transaksi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default Admin User
        User::updateOrCreate(
            ['email' => 'admin@kosan.com'],
            [
                'name' => 'Admin Kosan',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Create Rooms (Kamar)
        $kamarA1 = Kamar::updateOrCreate(['nomor_kamar' => 'A1'], ['harga_bulanan' => 1500000, 'deskripsi' => 'Kamar standar, AC, Kasur Single']);
        $kamarA2 = Kamar::updateOrCreate(['nomor_kamar' => 'A2'], ['harga_bulanan' => 1500000, 'deskripsi' => 'Kamar standar, AC, Kasur Single']);
        $kamarA3 = Kamar::updateOrCreate(['nomor_kamar' => 'A3'], ['harga_bulanan' => 1700000, 'deskripsi' => 'Kamar menengah, AC, Kamar Mandi Dalam']);
        $kamarB1 = Kamar::updateOrCreate(['nomor_kamar' => 'B1'], ['harga_bulanan' => 2000000, 'deskripsi' => 'Kamar VIP, AC, Kamar Mandi Dalam, TV, Air Panas']);
        $kamarB2 = Kamar::updateOrCreate(['nomor_kamar' => 'B2'], ['harga_bulanan' => 2000000, 'deskripsi' => 'Kamar VIP, AC, Kamar Mandi Dalam, TV, Air Panas']);

        // 3. Create Residents (Penghuni)
        // Today's day of month
        $today = Carbon::now();
        $todayDay = $today->day;
        
        // Siti Aminah: Entered 1 month ago on the same day -> should be due today!
        $sitiEntry = Carbon::now()->subMonth();
        $penghuni1 = Penghuni::updateOrCreate(
            ['nama' => 'Siti Aminah'],
            [
                'kamar_id' => $kamarA2->id,
                'no_wa' => '6289876543210',
                'tanggal_masuk' => $sitiEntry,
                'status_aktif' => true,
            ]
        );

        // Rian Hidayat: Entered today -> should be due today! (Since it's their entry date, though normally billing starts next month, they are technically matched. To make it more realistic, let's say they entered on the same day 2 months ago).
        $rianEntry = Carbon::now()->subMonths(2);
        $penghuni2 = Penghuni::updateOrCreate(
            ['nama' => 'Rian Hidayat'],
            [
                'kamar_id' => $kamarA3->id,
                'no_wa' => '628555444333',
                'tanggal_masuk' => $rianEntry,
                'status_aktif' => true,
            ]
        );

        // Budi Santoso: Entered on a different day (e.g. entry day is today + 5 days) -> not due today!
        $budiEntry = Carbon::now()->subMonths(1)->day($todayDay == 1 ? 15 : ($todayDay > 25 ? 5 : $todayDay + 3));
        $penghuni3 = Penghuni::updateOrCreate(
            ['nama' => 'Budi Santoso'],
            [
                'kamar_id' => $kamarA1->id,
                'no_wa' => '6281234567890',
                'tanggal_masuk' => $budiEntry,
                'status_aktif' => true,
            ]
        );

        // Andi Wijaya: Entered on a different day (e.g. entry day is today - 3 days) -> not due today!
        $andiEntry = Carbon::now()->subMonths(1)->day($todayDay > 4 ? $todayDay - 3 : 20);
        $penghuni4 = Penghuni::updateOrCreate(
            ['nama' => 'Andi Wijaya'],
            [
                'kamar_id' => $kamarB1->id,
                'no_wa' => '628111222333',
                'tanggal_masuk' => $andiEntry,
                'status_aktif' => true,
            ]
        );

        // Lina Marlina: Inactive resident -> should be skipped even if their entry day matches today!
        $linaEntry = Carbon::now()->subMonths(3)->day($todayDay);
        $penghuni5 = Penghuni::updateOrCreate(
            ['nama' => 'Lina Marlina'],
            [
                'kamar_id' => $kamarB2->id,
                'no_wa' => '628222333444',
                'tanggal_masuk' => $linaEntry,
                'status_aktif' => false, // Inactive
            ]
        );
        
        // 4. Create some past transactions
        // Siti has a past transaction that is already paid
        Transaksi::updateOrCreate(
            [
                'penghuni_id' => $penghuni1->id,
                'bulan_tagihan' => Carbon::now()->subMonth()->format('Y-m'),
            ],
            [
                'jumlah_tagihan' => $kamarA2->harga_bulanan,
                'status' => 'Lunas',
                'tanggal_bayar' => Carbon::now()->subMonth()->addDays(2),
            ]
        );
    }
}
