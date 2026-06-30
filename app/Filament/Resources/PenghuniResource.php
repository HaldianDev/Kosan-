<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenghuniResource\Pages;
use App\Models\Penghuni;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PenghuniResource extends Resource
{
    protected static ?string $model = Penghuni::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationLabel = 'Manajemen Penghuni';
    
    protected static ?string $modelLabel = 'Penghuni';
    
    protected static ?string $pluralModelLabel = 'Penghuni';
    
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->placeholder('Nama Lengkap Penghuni')
                            ->maxLength(255)
                            ->label('Nama Lengkap'),
                        
                        Forms\Components\TextInput::make('no_wa')
                            ->required()
                            ->tel()
                            ->placeholder('Contoh: 628123456789')
                            ->regex('/^628[0-9]+$/')
                            ->validationMessages([
                                'regex' => 'Nomor WhatsApp wajib menggunakan kode negara (628...) dan hanya angka.',
                            ])
                            ->label('No. WhatsApp'),
                        
                        Forms\Components\DatePicker::make('tanggal_masuk')
                            ->required()
                            ->default(now())
                            ->label('Tanggal Masuk'),
                        
                        Forms\Components\Select::make('kamar_id')
                            ->relationship(
                                'kamar', 
                                'nomor_kamar',
                                modifyQueryUsing: function (Builder $query, Forms\Get $get, ?Penghuni $record) {
                                    // Only show vacant rooms, or the resident's currently assigned room when editing
                                    return $query->whereDoesntHave('penghunis', function ($q) use ($record) {
                                        $q->where('status_aktif', true);
                                        if ($record) {
                                            $q->where('id', '!=', $record->id);
                                        }
                                    });
                                }
                            )
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih Kamar Terbuka')
                            ->required()
                            ->label('Kamar'),
                        
                        Forms\Components\Toggle::make('status_aktif')
                            ->default(true)
                            ->label('Status Aktif')
                            ->helperText('Matikan jika penghuni sudah keluar dari kosan'),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->label('Nama'),
                
                Tables\Columns\TextColumn::make('no_wa')
                    ->searchable()
                    ->label('No. WhatsApp'),
                
                Tables\Columns\TextColumn::make('kamar.nomor_kamar')
                    ->searchable()
                    ->sortable()
                    ->label('Kamar')
                    ->placeholder('-'),
                
                Tables\Columns\TextColumn::make('tanggal_masuk')
                    ->date('d M Y')
                    ->sortable()
                    ->label('Tanggal Masuk'),
                
                Tables\Columns\IconColumn::make('status_aktif')
                    ->boolean()
                    ->sortable()
                    ->label('Status Aktif'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('status_aktif')
                    ->label('Status Aktif')
                    ->trueLabel('Aktif')
                    ->falseLabel('Non-Aktif')
                    ->default(true),
                
                Tables\Filters\SelectFilter::make('kamar_id')
                    ->relationship('kamar', 'nomor_kamar')
                    ->label('Filter Kamar'),
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
            'index' => Pages\ListPenghunis::route('/'),
            'create' => Pages\CreatePenghuni::route('/create'),
            'edit' => Pages\EditPenghuni::route('/{record}/edit'),
        ];
    }
}
