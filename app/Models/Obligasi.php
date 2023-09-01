<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Obligasi extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'obligasi';
    protected $primaryKey = 'obligasi_id';
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
        'penerbit',
        'nilai_nominal',
        'kupon',
        'tipe_kupon',
        'haircut',
        'nilai_tersedia',
        'tanggal_penerbitan',
        'tanggal_jatuh_tempo',
        'lokasi',
    ];

    public function surat_berharga()
    {
        return $this->belongsTo(SuratBerharga::class, 'surat_berharga_id', 'surat_berharga_id');
    }
}
