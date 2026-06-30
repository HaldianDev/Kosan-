<?php

namespace App\Filament\Widgets;

use App\Models\Penghuni;
use App\Models\Transaksi;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class DueTodayWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Penghuni Jatuh Tempo Hari Ini';

    public function table(Table $table): Table
    {
        $todayDay = now()->day;
        $isLastDayOfMonth = now()->isLastOfMonth();

        return $table
            ->query(
                Penghuni::query()
                    ->where('status_aktif', true)
                    ->where(function (Builder $query) use ($todayDay, $isLastDayOfMonth) {
                        $query->whereDay('tanggal_masuk', $todayDay);
                        if ($isLastDayOfMonth) {
                            $query->orWhereRaw("cast(strftime('%d', tanggal_masuk) as integer) > ?", [$todayDay]);
                        }
                    })
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->weight('bold')
                    ->label('Nama Penghuni'),
                
                Tables\Columns\TextColumn::make('kamar.nomor_kamar')
                    ->label('Kamar')
                    ->placeholder('-'),
                
                Tables\Columns\TextColumn::make('no_wa')
                    ->label('WhatsApp'),
                
                Tables\Columns\TextColumn::make('tanggal_masuk')
                    ->date('d M Y')
                    ->label('Tanggal Masuk'),

                Tables\Columns\TextColumn::make('status_bulan_ini')
                    ->label('Tagihan Bulan Ini')
                    ->badge()
                    ->state(function (Penghuni $record) {
                        $tx = $record->transaksis()->where('bulan_tagihan', now()->format('Y-m'))->first();
                        if (!$tx) return 'Belum Dibuat';
                        return $tx->status;
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Lunas' => 'success',
                        'Belum Lunas' => 'warning',
                        'Belum Dibuat' => 'gray',
                        default => 'gray',
                    }),
            ])
            ->actions([
                // Action 1: Create Bill & Send WA
                Tables\Actions\Action::make('buatTagihan')
                    ->label('Buat Tagihan')
                    ->icon('heroicon-o-plus-circle')
                    ->color('primary')
                    ->visible(function (Penghuni $record) {
                        return !$record->transaksis()->where('bulan_tagihan', now()->format('Y-m'))->exists();
                    })
                    ->action(function (Penghuni $record) {
                        if (!$record->kamar) {
                            Notification::make()->title('Penghuni tidak memiliki kamar')->danger()->send();
                            return;
                        }
                        
                        $bulanTagihan = now()->format('Y-m');
                        $amount = $record->kamar->harga_bulanan;
                        
                        $tx = Transaksi::create([
                            'penghuni_id' => $record->id,
                            'bulan_tagihan' => $bulanTagihan,
                            'jumlah_tagihan' => $amount,
                            'status' => 'Belum Lunas',
                        ]);

                        // Send WA
                        $whatsapp = app(WhatsAppService::class);
                        $bulanFormatted = Carbon::parse($bulanTagihan . '-01')->translatedFormat('F Y');
                        
                        $message = "Halo *{$record->nama}*,\n\n"
                                 . "Ini adalah rincian tagihan kosan Anda untuk bulan *{$bulanFormatted}*:\n"
                                 . "- Kamar: *{$record->kamar->nomor_kamar}*\n"
                                 . "- Jumlah: *Rp " . number_format($amount, 0, ',', '.') . "*\n"
                                 . "- Status: *Belum Lunas*\n\n"
                                 . "Silakan lakukan pembayaran ke rekening admin dan konfirmasi pembayaran melalui WhatsApp ini.\n\n"
                                 . "Terima kasih!";

                        $result = $whatsapp->send($record->no_wa, $message);

                        Notification::make()
                            ->title('Tagihan dibuat' . ($result['success'] ? ' & WA Terkirim' : ' (Gagal Kirim WA)'))
                            ->success()
                            ->send();
                    }),

                // Action 2: Confirm Payment
                Tables\Actions\Action::make('bayarTagihan')
                    ->label('Bayar')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(function (Penghuni $record) {
                        $tx = $record->transaksis()->where('bulan_tagihan', now()->format('Y-m'))->first();
                        return $tx && $tx->status === 'Belum Lunas';
                    })
                    ->action(function (Penghuni $record) {
                        $tx = $record->transaksis()->where('bulan_tagihan', now()->format('Y-m'))->first();
                        if ($tx) {
                            $tx->update([
                                'status' => 'Lunas',
                                'tanggal_bayar' => now(),
                            ]);
                            Notification::make()->title('Tagihan dikonfirmasi Lunas')->success()->send();
                        }
                    }),

                // Action 3: Send WA reminder
                Tables\Actions\Action::make('ingatkanWa')
                    ->label('Kirim Pengingat')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('info')
                    ->visible(function (Penghuni $record) {
                        $tx = $record->transaksis()->where('bulan_tagihan', now()->format('Y-m'))->first();
                        return $tx && $tx->status === 'Belum Lunas';
                    })
                    ->action(function (Penghuni $record) {
                        $tx = $record->transaksis()->where('bulan_tagihan', now()->format('Y-m'))->first();
                        if ($tx) {
                            $whatsapp = app(WhatsAppService::class);
                            $bulanFormatted = Carbon::parse($tx->bulan_tagihan . '-01')->translatedFormat('F Y');
                            
                            $message = "Halo *{$record->nama}*,\n\n"
                                     . "Mengingatkan kembali untuk tagihan kosan Anda bulan *{$bulanFormatted}*:\n"
                                     . "- Kamar: *{$record->kamar->nomor_kamar}*\n"
                                     . "- Jumlah: *Rp " . number_format($tx->jumlah_tagihan, 0, ',', '.') . "*\n"
                                     . "- Status: *Belum Lunas*\n"
                                     . "- Rekening BRI: *5661 0103 3699 536* a/n *Eka Cahya*\n\n"
                                     . "Silakan lakukan pembayaran ke rekening admin dan konfirmasi pembayaran melalui WhatsApp ini.\n\n"
                                     . "Terima kasih!";

                            $result = $whatsapp->send($record->no_wa, $message);

                            if ($result['success']) {
                                Notification::make()->title('Pengingat WA terkirim')->success()->send();
                            } else {
                                Notification::make()->title('Gagal mengirim WA: ' . $result['message'])->danger()->send();
                            }
                        }
                    }),
            ]);
    }
}
