<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Lelang extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'lelang';
    protected $primaryKey = 'lelang_id';
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
        'jenis_perdagangan_id',
        'jenis_inisiasi_id',
        'kontrak_id',
        'jenis_harga_id',
        'nomor_lelang',
        'asal_komoditas',
        'kuantitas',
        'judul',
        'spesifikasi_produk',
        'kemasan',
        'lokasi_penyerahan',
        'harga_awal',
        'kelipatan_penawaran',
        'harga_beli_sekarang'
    ];

    public function peserta_lelang_berlangsung()
    {
        return $this->hasMany(PesertaLelangBerlangsung::class, 'lelang_id', 'lelang_id');
    }

    public function daftar_peserta_lelang_berlangsung()
    {
        return $this->hasMany(DaftarPesertalelangBerlangsung::class, 'lelang_id', 'lelang_id');
    }

    public function jenis_perdagangan()
    {
        return $this->belongsTo(JenisPerdagangan::class, 'jenis_perdagangan_id', 'jenis_perdagangan_id');
    }

    public function jenis_inisiasi()
    {
        return $this->belongsTo(JenisInisiasi::class, 'jenis_inisiasi_id', 'jenis_inisiasi_id');
    }

    public function kontrak()
    {
        return $this->belongsTo(Kontrak::class, 'kontrak_id', 'kontrak_id');
    }

    public function jenis_harga()
    {
        return $this->belongsTo(JenisHarga::class, 'jenis_harga_id', 'jenis_harga_id');
    }

    public function lelang_verified_sesi()
    {
        return $this->hasOne(LelangVerifiedSesi::class, 'lelang_id', 'lelang_id');
    }

    public function event_lelang()
    {
        return $this->belongsToMany(EventLelang::class, 'event_lelang_relation', 'lelang_id', 'event_lelang_id');
    }

    public function jaminan_lelang()
    {
        return $this->hasOne(JaminanLelang::class, 'lelang_id', 'lelang_id');
    }

    public function dokumen_produk()
    {
        return $this->hasMany(DokumenProduk::class, 'lelang_id', 'lelang_id');
    }

    public function jenis_platform_lelang()
    {
        return $this->hasOne(JenisPlatformLelang::class, 'lelang_id', 'lelang_id');
    }

    public function status_lelang()
    {
        return $this->belongsToMany(StatusLelang::class, 'status_lelang_pivot', 'lelang_id', 'lelang_id');
    }

    public function status_lelang_pivot()
    {
        return $this->hasMany(StatusLelangPivot::class, 'lelang_id', 'lelang_id');
    }

    public function lelang_sesi_online()
    {
        return $this->hasMany(LelangSesiOnline::class, 'lelang_id', 'lelang_id');
    }
}
