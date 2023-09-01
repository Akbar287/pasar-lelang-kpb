<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class KeuanganKeluar extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'keuangan_keluar';
    protected $primaryKey = 'keuangan_keluar_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }
    protected $fillable = [
        'pembayaran_lelang_id',
        'no_instruksi',
        'tanggal_instruksi',
        'status',
    ];

    public function pembayaran_lelang()
    {
        return $this->belongsTo(PembayaranLelang::class, 'pembayaran_lelang_id', 'pembayaran_lelang_id');
    }

    public function rekening_keuangan_asal()
    {
        return $this->hasOne(RekeningKeuanganAsal::class, 'keuangan_keluar_id', 'keuangan_keluar_id');
    }
}
