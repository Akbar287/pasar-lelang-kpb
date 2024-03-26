<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class RekeningPusat extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'rekening_pusat';
    protected $primaryKey = 'rekening_pusat_id';
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
        'bank_id',
        'nomor_rekening',
        'nama_pemilik',
        'cabang',
        'mata_uang',
        'saldo',
        'aktif',
        'status'
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'bank_id');
    }

    public function dana_keuangan()
    {
        return $this->hasMany(DanaKeuangan::class, 'rekening_pusat_id', 'rekening_pusat_id');
    }
}
