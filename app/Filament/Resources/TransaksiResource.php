<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Models\Transaksi;
use App\Models\Penghuni;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    
    protected static ?string $navigationLabel = 'Riwayat Transaksi';
    
    protected static ?string $modelLabel = 'Transaksi';
    
    protected static ?string $pluralModelLabel = 'Transaksi';
    
    protected static ?string $navigationGroup = 'Keuangan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Select::make('penghuni_id')
                            ->relationship('penghuni', 'nama', modifyQueryUsing: fn ($query) => $query->where('status_aktif', true))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $penghuni = Penghuni::with('kamar')->find($state);
                                    if ($penghuni && $penghuni->kamar) {
                                        $set('jumlah_tagihan', $penghuni->kamar->harga_bulanan);
                                    }
                                }
                            })
                            ->label('Penghuni'),
                        
                        Forms\Components\TextInput::make('bulan_tagihan')
                            ->required()
                            ->placeholder('Format: YYYY-MM, contoh: ' . now()->format('Y-m'))
                            ->regex('/^\d{4}-\d{2}$/')
                            ->validationMessages([
                                'regex' => 'Format bulan wajib YYYY-MM (misal: 2026-06)',
                            ])
                            ->label('Bulan Tagihan'),
                        
                        Forms\Components\TextInput::make('jumlah_tagihan')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Jumlah Tagihan'),
                        
                        Forms\Components\Select::make('status')
                            ->options([
                                'Belum Lunas' => 'Belum Lunas',
                                'Lunas' => 'Lunas',
                            ])
                            ->default('Belum Lunas')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state === 'Lunas') {
                                    $set('tanggal_bayar', now()->format('Y-m-d'));
                                } else {
                                    $set('tanggal_bayar', null);
                                }
                            })
                            ->label('Status Pembayaran'),
                        
                        Forms\Components\DatePicker::make('tanggal_bayar')
                            ->nullable()
                            ->label('Tanggal Bayar'),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('penghuni.nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->label('Nama Penghuni'),
                
                Tables\Columns\TextColumn::make('penghuni.kamar.nomor_kamar')
                    ->searchable()
                    ->sortable()
                    ->label('Kamar')
                    ->placeholder('-'),
                
                Tables\Columns\TextColumn::make('bulan_tagihan')
                    ->searchable()
                    ->sortable()
                    ->label('Bulan Tagihan')
                    ->formatStateUsing(function (string $state) {
                        return Carbon::parse($state . '-01')->translatedFormat('F Y');
                    }),
                
                Tables\Columns\TextColumn::make('jumlah_tagihan')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->label('Tagihan'),
                
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Lunas' => 'success',
                        'Belum Lunas' => 'warning',
                        default => 'gray',
                    })
                    ->sortable()
                    ->label('Status'),
                
                Tables\Columns\TextColumn::make('tanggal_bayar')
                    ->date('d M Y')
                    ->sortable()
                    ->placeholder('-')
                    ->label('Tanggal Bayar'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Lunas' => 'Lunas',
                        'Belum Lunas' => 'Belum Lunas',
                    ])
                    ->label('Filter Status'),
                
                Tables\Filters\Filter::make('bulan_sekarang')
                    ->query(fn ($query) => $query->where('bulan_tagihan', now()->format('Y-m')))
                    ->label('Bulan Ini'),
            ])
            ->actions([
                Tables\Actions\Action::make('konfirmasiLunas')
                    ->label('Bayar')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Transaksi $record): bool => $record->status === 'Belum Lunas')
                    ->action(function (Transaksi $record) {
                        $record->update([
                            'status' => 'Lunas',
                            'tanggal_bayar' => now(),
                        ]);
                        
                        Notification::make()
                            ->title('Pembayaran berhasil dikonfirmasi')
                            ->success()
                            ->send();
                    }),
                
                Tables\Actions\Action::make('kirimPengingat')
                    ->label('WA')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('info')
                    ->requiresConfirmation()
                    ->visible(fn (Transaksi $record): bool => $record->status === 'Belum Lunas')
                    ->action(function (Transaksi $record) {
                        $whatsapp = app(WhatsAppService::class);
                        $bulanFormatted = Carbon::parse($record->bulan_tagihan . '-01')->translatedFormat('F Y');
                        
                        $result = $whatsapp->send($record->penghuni->no_wa, $message);

                        if ($result['success']) {
                            Notification::make()
                                ->title('Pengingat WA berhasil dikirim')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Gagal mengirim pengingat: ' . $result['message'])
                                ->danger()
                                ->send();
                        }
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }
}
