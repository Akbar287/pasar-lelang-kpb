<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class DokumenSettlement extends Model
{
    use HasFactory;
    protected $table = 'dokumen_settlement';
    protected $primaryKey = 'dokumen_settlement_id';
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
        'tangal_mulai',
        'tenggat_waktu',
        'nilai_kesepakatan',
        'nilai_tagihan_pembeli',
        'total_pembayaran_ke_penjual'
    ];

    public function informasi_akun()
    {
        return $this->belongsToMany(InformasiAkun::class, 'dokumen_settlement_member', 'dokumen_settlement_id', 'informasi_akun_id');
    }

    public function jaminan_komoditas()
    {
        return $this->hasOne(JaminanKomoditas::class, 'dokumen_settlement_id', 'dokumen_settlement_id');
    }

    public function release_cash()
    {
        return $this->hasOne(ReleaseCash::class, 'dokumen_settlement_id', 'dokumen_settlement_id');
    }
}
