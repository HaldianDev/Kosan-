<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penghuni extends Model
{
    use HasFactory;

    protected $fillable = [
        'kamar_id',
        'nama',
        'no_wa',
        'tanggal_masuk',
        'status_aktif',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'status_aktif' => 'boolean',
    ];

    /**
     * Get the room assigned to the resident.
     */
    public function kamar(): BelongsTo
    {
        return $this->belongsTo(Kamar::class);
    }

    /**
     * Get all transactions/payments for this resident.
     */
    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class);
    }
}
