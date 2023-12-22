<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class JenisDokumenProduk extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'jenis_dokumen_produk';
    protected $primaryKey = 'jenis_dokumen_produk_id';
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
        'nama_jenis'
    ];

    public function dokumen_produk()
    {
        return $this->hasMany(DokumenProduk::class, 'jenis_dokumen_produk_id', 'jenis_dokumen_produk_id');
    }
}
