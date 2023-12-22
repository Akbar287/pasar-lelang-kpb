<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class WaktuPenyerahan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'waktu_penyerahan';
    protected $primaryKey = 'waktu_penyerahan_id';
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
        'nomor_surat_id',
        'tanggal',
        'waktu',
        'volume'
    ];

    public function nomor_surat()
    {
        return $this->belongsTo(NomorSurat::class, 'nomor_surat_id', 'nomor_surat_id');
    }
}
