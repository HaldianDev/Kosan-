<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'penghuni_id',
        'bulan_tagihan',
        'jumlah_tagihan',
        'status',
        'tanggal_bayar',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
    ];

    /**
     * Get the resident who owns the transaction.
     */
    public function penghuni(): BelongsTo
    {
        return $this->belongsTo(Penghuni::class);
    }
}
