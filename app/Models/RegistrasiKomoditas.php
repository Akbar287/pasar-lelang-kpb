<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class RegistrasiKomoditas extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'registrasi_komoditas';
    protected $primaryKey = 'registrasi_komoditas_id';
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
        'jenis_registrasi_komoditas_id',
        'status_registrasi_komoditas_id',
        'komoditas_id',
        'mutu_id',
        'gudang_id',
        'tanggal',
        'kode_transaksi',
        'no_instruksi',
        'quantity',
        'nilai',
        'no_bast',
        'kadaluarsa',
        'keterangan',
    ];

    public function jenis_registrasi_komoditas()
    {
        return $this->belongsTo(JenisRegistrasiKomoditas::class, 'jenis_registrasi_komoditas_id', 'jenis_registrasi_komoditas_id');
    }

    public function informasi_akun()
    {
        return $this->belongsTo(InformasiAkun::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function komoditas()
    {
        return $this->belongsTo(Komoditas::class, 'komoditas_id', 'komoditas_id');
    }

    public function mutu()
    {
        return $this->belongsTo(Mutu::class, 'mutu_id', 'mutu_id');
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'gudang_id', 'gudang_id');
    }

    public function status_registrasi_komoditas()
    {
        return $this->belongsTo(StatusRegistrasiKomoditas::class, 'status_registrasi_komoditas_id', 'status_registrasi_komoditas_id');
    }

    public function registrasi_komoditas_alokasi()
    {
        return $this->hasOne(RegistrasiKomoditasAlokasi::class, 'registrasi_komoditas_id', 'registrasi_komoditas_id');
    }

    public function verified_log()
    {
        return $this->belongsToMany(VerifiedLog::class, 'registrasi_komoditas_verified_log', 'registrasi_komoditas_id', 'verified_log_id');
    }
}
