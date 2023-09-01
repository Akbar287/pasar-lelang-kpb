<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Kontrak extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'kontrak';
    protected $primaryKey = 'kontrak_id';
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
        'penyelenggara_pasar_lelang_id',
        'komoditas_id',
        'jenis_perdagangan_id',
        'mutu_id',
        'informasi_akun_id',
        'status_kontrak_id',
        'kontrak_kode',
        'simbol',
        'minimum_transaksi',
        'maksimum_transaksi',
        'fluktuasi_harga_harian',
        'premium',
        'diskon',
        'jatuh_tempo_t_plus',
        'tanggal_aktif',
        'tanggal_berakhir',
        'keterangan',
        'tanggal_verifikasi',
        'is_aktif',
        'is_verified',
        'is_status_verified',
    ];

    public function penyelenggara_pasar_lelang()
    {
        return $this->belongsTo(PenyelenggaraPasarLelang::class, 'penyelenggara_pasar_lelang_id', 'penyelenggara_pasar_lelang_id');
    }

    public function komoditas()
    {
        return $this->belongsTo(Komoditas::class, 'komoditas_id', 'komoditas_id');
    }

    public function informasi_akun()
    {
        return $this->belongsTo(InformasiAkun::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function jenis_perdagangan()
    {
        return $this->belongsTo(JenisPerdagangan::class, 'jenis_perdagangan_id', 'jenis_perdagangan_id');
    }

    public function mutu()
    {
        return $this->belongsTo(Mutu::class, 'mutu_id', 'mutu_id');
    }

    public function status_kontrak()
    {
        return $this->belongsTo(StatusKontrak::class, 'status_kontrak_id', 'status_kontrak_id');
    }

    public function lelang()
    {
        return $this->hasMany(Lelang::class, 'kontrak_id', 'kontrak_id');
    }

    public function kontrak_keuangan()
    {
        return $this->hasOne(KontrakKeuangan::class, 'kontrak_id', 'kontrak_id');
    }
}
