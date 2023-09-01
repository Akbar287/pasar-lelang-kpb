<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Deposito extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'deposito';
    protected $primaryKey = 'deposito_id';
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
        'tanggal_terima',
        'no_sertifikat',
        'no_rekening',
        'tanggal_terbit',
        'tanggal_jatuh_tempo',
        'tanggal_valuta',
        'bank_penerbit',
        'nilai_nominal',
        'haircut',
        'nilai_tersedia',
    ];

    public function surat_berharga()
    {
        return $this->belongsTo(SuratBerharga::class, 'surat_berharga_id', 'surat_berharga_id');
    }
}
