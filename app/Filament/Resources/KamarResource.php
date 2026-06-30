<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KamarResource\Pages;
use App\Models\Kamar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KamarResource extends Resource
{
    protected static ?string $model = Kamar::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';
    
    protected static ?string $navigationLabel = 'Manajemen Kamar';
    
    protected static ?string $modelLabel = 'Kamar';
    
    protected static ?string $pluralModelLabel = 'Kamar';
    
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('nomor_kamar')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->placeholder('Contoh: A1, B2, 101')
                            ->maxLength(255)
                            ->label('Nomor Kamar'),
                        
                        Forms\Components\TextInput::make('harga_bulanan')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->placeholder('Harga sewa per bulan')
                            ->label('Harga Bulanan'),
                        
                        Forms\Components\Textarea::make('deskripsi')
                            ->placeholder('Deskripsi fasilitas (misal: AC, Kamar Mandi Dalam, Kasur)')
                            ->columnSpanFull()
                            ->label('Deskripsi Fasilitas'),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_kamar')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->label('No. Kamar'),
                
                Tables\Columns\TextColumn::make('harga_bulanan')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->label('Harga Bulanan'),
                
                Tables\Columns\TextColumn::make('penghuniAktif.nama')
                    ->label('Penghuni Aktif')
                    ->placeholder('Kosong (Tersedia)')
                    ->searchable()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Terisi' => 'danger',
                        'Tersedia' => 'success',
                        default => 'gray',
                    }),
                
                Tables\Columns\TextColumn::make('deskripsi')
                    ->limit(50)
                    ->label('Deskripsi')
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('tersedia')
                    ->query(fn ($query) => $query->whereDoesntHave('penghunis', fn ($q) => $q->where('status_aktif', true)))
                    ->label('Hanya Kamar Tersedia'),
                Tables\Filters\Filter::make('terisi')
                    ->query(fn ($query) => $query->whereHas('penghunis', fn ($q) => $q->where('status_aktif', true)))
                    ->label('Hanya Kamar Terisi'),
            ])
            ->actions([
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
            'index' => Pages\ListKamars::route('/'),
            'create' => Pages\CreateKamar::route('/create'),
            'edit' => Pages\EditKamar::route('/{record}/edit'),
        ];
    }
}
