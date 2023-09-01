<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class InformasiKeuangan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'informasi_keuangan';
    protected $primaryKey = 'informasi_keuangan_id';
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
        'npwp_id',
        'member_id',
        'pekerjaan',
        'pendapatan_tahunan',
        'kekayaan_bersih',
        'kekayaan_lancar',
        'sumber_dana',
        'keterangan'
    ];

    public function npwp()
    {
        return $this->belongsTo(Npwp::class, 'npwp_id', 'npwp_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }
}
