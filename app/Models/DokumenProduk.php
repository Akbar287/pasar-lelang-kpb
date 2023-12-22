<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class DokumenProduk extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'dokumen_produk';
    protected $primaryKey = 'dokumen_produk_id';
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
        'jenis_dokumen_produk_id',
        'lelang_id',
        'keterangan',
        'nama_dokumen',
        'nama_file',
        'tanggal_upload',
        'is_gambar_utama',
    ];

    public function lelang()
    {
        return $this->belongsTo(Lelang::class, 'lelang_id', 'lelang_id');
    }

    public function jenis_dokumen_produk()
    {
        return $this->belongsTo(JenisDokumenProduk::class, 'jenis_dokumen_produk_id', 'jenis_dokumen_produk_id');
    }
}
