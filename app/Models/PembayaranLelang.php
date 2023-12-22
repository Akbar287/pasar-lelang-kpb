<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class PembayaranLelang extends Model
{
    use HasFactory;
    protected $table = 'pembayaran_lelang';
    protected $primaryKey = 'pembayaran_lelang_id';
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
        'status_penyelesaian_id',
        'approval_lelang_id',
        'nomor_penyelesaian',
        'tanggal_pembayaran',
        'tanggal_jatuh_tempo',
        'keterangan'
    ];

    public function opsi_pembayaran_lelang()
    {
        return $this->hasMany(OpsiPembayaranLelang::class, 'pembayaran_lelang_id', 'pembayaran_lelang_id');
    }

    public function status_penyelesaian()
    {
        return $this->belongsTo(StatusPenyelesaian::class, 'status_penyelesaian_id', 'status_penyelesaian_id');
    }

    public function approval_lelang()
    {
        return $this->belongsTo(ApprovalLelang::class, 'approval_lelang_id', 'approval_lelang_id');
    }

    public function keuangan_keluar()
    {
        return $this->hasOne(KeuanganKeluar::class, 'pembayaran_lelang_id', 'pembayaran_lelang_id');
    }

    public function komoditas_masuk()
    {
        return $this->hasOne(KomoditasMasuk::class, 'pembayaran_lelang_id', 'pembayaran_lelang_id');
    }

    public function komoditas_keluar()
    {
        return $this->hasOne(KomoditasKeluar::class, 'pembayaran_lelang_id', 'pembayaran_lelang_id');
    }

    public function keuangan_masuk()
    {
        return $this->hasOne(KeuanganMasuk::class, 'pembayaran_lelang_id', 'pembayaran_lelang_id');
    }

    public function verified_log()
    {
        return $this->belongsToMany(VerifiedLog::class, 'pembayaran_lelang_verified_log', 'pembayaran_lelang_id', 'verified_log_id');
    }
}
