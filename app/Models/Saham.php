<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Saham extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'saham';
    protected $primaryKey = 'saham_id';
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
        'kode_saham',
        'penerbit',
        'harga_saham',
        'lot',
        'nilai_saham',
        'haircut',
        'nilai_tersedia',
        'lokasi',
    ];

    public function surat_berharga()
    {
        return $this->belongsTo(SuratBerharga::class, 'surat_berharga_id', 'surat_berharga_id');
    }
}
