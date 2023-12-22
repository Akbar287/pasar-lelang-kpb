<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class SuratBerharga extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'surat_berharga';
    protected $primaryKey = 'surat_berharga_id';
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
        'jenis_surat_berharga_id',
        'detail_jaminan_id'
    ];

    public function jenis_surat_berharga()
    {
        return $this->belongsTo(JenisSuratBerharga::class, 'jenis_surat_berharga_id', 'jenis_surat_berharga_id');
    }

    public function detail_jaminan()
    {
        return $this->belongsTo(DetailJaminan::class, 'detail_jaminan_id', 'detail_jaminan_id');
    }

    public function saham()
    {
        return $this->hasMany(Saham::class, 'surat_berharga_id', 'surat_berharga_id');
    }

    public function deposito()
    {
        return $this->hasMany(Deposito::class, 'surat_berharga_id', 'surat_berharga_id');
    }

    public function resi_gudang()
    {
        return $this->hasMany(ResiGudang::class, 'surat_berharga_id', 'surat_berharga_id');
    }

    public function obligasi()
    {
        return $this->hasMany(Obligasi::class, 'surat_berharga_id', 'surat_berharga_id');
    }
}
