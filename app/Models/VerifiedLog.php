<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class VerifiedLog extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'verified_log';
    protected $primaryKey = 'verified_log_id';
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
        'admin_id',
        'jenis_verifikasi_id',
        'is_agree',
        'tanggal_verifikasi',
        'keterangan',
    ];

    public function informasi_akun()
    {
        return $this->belongsTo(InformasiAkun::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }

    public function suspend()
    {
        return $this->belongsTo(Suspend::class, 'verified_log_id', 'verified_log_id');
    }

    public function lelang_verified_sesi()
    {
        return $this->hasOne(LelangVerifiedSesi::class, 'verified_log_id', 'verified_log_id');
    }

    public function jenis_verifikasi()
    {
        return $this->belongsTo(JenisVerifikasi::class, 'jenis_verifikasi_id', 'jenis_verifikasi_id');
    }

    public function keuangan()
    {
        return $this->belongsToMany(Keuangan::class, 'keuangan_verified_log', 'verified_log_id', 'keuangan_id');
    }

    public function registrasi_komoditas()
    {
        return $this->belongsToMany(RegistrasiKomoditas::class, 'registrasi_komoditas_verified_log', 'verified_log_id', 'registrasi_komoditas_id');
    }

    public function detail_jaminan()
    {
        return $this->belongsToMany(DetailJaminan::class, 'detail_jaminan_verified_log', 'verified_log_id', 'detail_jaminan_id');
    }

    public function pengeluaran_jaminan()
    {
        return $this->belongsToMany(PengeluaranJaminan::class, 'pengeluaran_jaminan_verified_log', 'verified_log_id', 'pengeluaran_jaminan_id');
    }

    public function pembayaran_lelang()
    {
        return $this->belongsToMany(PembayaranLelang::class, 'pembayaran_lelang_verified_log', 'verified_log_id', 'pembayaran_lelang_id');
    }

    public function dana_keuangan()
    {
        return $this->hasOne(DanaKeuangan::class, 'verified_log_id', 'verified_log_id');
    }
}
