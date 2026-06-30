<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Penghuni;
use App\Models\Transaksi;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckBilling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-billing {--date= : Run the check for a specific date (YYYY-MM-DD)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Periksa jatuh tempo sewa penghuni kosan dan buat tagihan otomatis';

    protected WhatsAppService $whatsapp;

    public function __construct(WhatsAppService $whatsapp)
    {
        parent::__construct();
        $this->whatsapp = $whatsapp;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Allow passing a custom date for testing purposes
        $dateStr = $this->option('date');
        $today = $dateStr ? Carbon::parse($dateStr) : Carbon::now();
        
        $todayDay = $today->day;
        $isLastDayOfMonth = $today->isLastOfMonth();
        $bulanTagihan = $today->format('Y-m');

        $this->info("Memulai pengecekan tagihan untuk tanggal: {$today->toDateString()} (Hari ke-{$todayDay}, Bulan Tagihan: {$bulanTagihan})");

        // Fetch active residents with their room and transactions
        $residents = Penghuni::with(['kamar', 'transaksis'])
            ->where('status_aktif', true)
            ->get();

        $processedCount = 0;
        $createdCount = 0;

        foreach ($residents as $resident) {
            // Check if resident has an assigned room
            if (!$resident->kamar) {
                $this->warn("Penghuni ID {$resident->id} ({$resident->nama}) tidak memiliki kamar terikat. Melewati.");
                continue;
            }

            $entryDay = $resident->tanggal_masuk->day;
            $isDue = false;

            // Billing logic:
            // 1. Day of entry matches today's day.
            // 2. Or today is the last day of the month AND entry day is greater than today's day (e.g. entered on 31st, today is 30th).
            if ($entryDay === $todayDay) {
                $isDue = true;
            } elseif ($isLastDayOfMonth && $entryDay > $todayDay) {
                $isDue = true;
            }

            if ($isDue) {
                $processedCount++;

                // Check if transaction for this resident and billing month already exists
                $existingTx = Transaksi::where('penghuni_id', $resident->id)
                    ->where('bulan_tagihan', $bulanTagihan)
                    ->first();

                if ($existingTx) {
                    $this->line("Tagihan untuk {$resident->nama} di bulan {$bulanTagihan} sudah ada. Melewati.");
                    continue;
                }

                // Create new transaction
                $amount = $resident->kamar->harga_bulanan;
                $transaction = Transaksi::create([
                    'penghuni_id' => $resident->id,
                    'bulan_tagihan' => $bulanTagihan,
                    'jumlah_tagihan' => $amount,
                    'status' => 'Belum Lunas',
                ]);

                $createdCount++;
                $this->info("Tagihan dibuat untuk {$resident->nama} - Kamar {$resident->kamar->nomor_kamar} sejumlah Rp " . number_format($amount, 0, ',', '.'));

                // Send WhatsApp broadcast
                $this->sendWhatsAppNotification($resident, $bulanTagihan, $amount);
            }
        }

        $this->info("Selesai! Penghuni jatuh tempo: {$processedCount}, Tagihan baru dibuat: {$createdCount}");
        return Command::SUCCESS;
    }

    /**
     * Send WhatsApp notification to resident.
     */
    protected function sendWhatsAppNotification(Penghuni $resident, string $bulanTagihan, int $amount)
    {
        $bulanFormatted = Carbon::parse($bulanTagihan . '-01')->translatedFormat('F Y');
        
        $message = "Halo *{$resident->nama}*,\n\n"
                 . "Ini adalah rincian tagihan kosan Anda untuk bulan *{$bulanFormatted}*:\n"
                 . "- Kamar: *{$resident->kamar->nomor_kamar}*\n"
                 . "- Jumlah: *Rp " . number_format($amount, 0, ',', '.') . "*\n"
                 . "- Status: *Belum Lunas*\n"
                 . "- Rekening BRI: *5661 0103 3699 536* a/n *Eka Cahya*\n\n"
                 . "Silakan lakukan pembayaran ke rekening admin dan konfirmasi pembayaran melalui WhatsApp ini.\n\n"
                 . "Terima kasih!";

        $result = $this->whatsapp->send($resident->no_wa, $message);

        if ($result['success']) {
            $this->info("WhatsApp terkirim ke {$resident->nama} ({$resident->no_wa})");
        } else {
            $this->error("Gagal mengirim WhatsApp ke {$resident->nama}: " . $result['message']);
        }
    }
}
