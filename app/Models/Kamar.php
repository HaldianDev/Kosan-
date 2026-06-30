<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kamar extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_kamar',
        'harga_bulanan',
        'deskripsi',
    ];

    /**
     * Get all residents for this room.
     */
    public function penghunis(): HasMany
    {
        return $this->hasMany(Penghuni::class);
    }

    /**
     * Get the current active resident in this room.
     */
    public function penghuniAktif(): HasOne
    {
        return $this->hasOne(Penghuni::class)->where('status_aktif', true);
    }

    /**
     * Helper to get status: 'Terisi' or 'Tersedia'
     */
    public function getStatusAttribute(): string
    {
        return $this->penghuniAktif()->exists() ? 'Terisi' : 'Tersedia';
    }
}
