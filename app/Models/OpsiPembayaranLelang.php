<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class OpsiPembayaranLelang extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'opsi_pembayaran_lelang';
    protected $primaryKey = 'opsi_pembayaran_lelang_id';
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
        'informasi_akun_id',
        'pembayaran_lelang_id',
        'jenis_opsi_pembayaran_lelang_id',
        'jenis_informasi_akun',
        'tagihan',
        'biaya_lain_lain',
        'penyelesaian',
    ];

    public function informasi_akun()
    {
        return $this->belongsTo(InformasiAkun::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function jenis_opsi_pembayaran_lelang()
    {
        return $this->belongsTo(JenisOpsiPembayaranLelang::class, 'jenis_opsi_pembayaran_lelang_id', 'jenis_opsi_pembayaran_lelang_id');
    }

    public function pembayaran_lelang()
    {
        return $this->belongsTo(PembayaranLelang::class, 'pembayaran_lelang_id', 'pembayaran_lelang_id');
    }
}
