<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class ResiGudang extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'resi_gudang';
    protected $primaryKey = 'resi_gudang_id';
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
        'surat_berharga_id',
        'jenis',
        'pemilik_barang',
        'pemegang_resi_gudang',
        'no_penerbitan',
        'nama_resi_gudang',
        'nilai_resi_gudang',
        'haircut',
        'nilai_tersedia',
        'tanggal_penerbitan',
        'tanggal_jatuh_tempo',
    ];

    public function surat_berharga()
    {
        return $this->belongsTo(SuratBerharga::class, 'surat_berharga_id', 'surat_berharga_id');
    }
}
