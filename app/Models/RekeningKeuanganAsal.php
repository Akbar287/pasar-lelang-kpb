<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class RekeningKeuanganAsal extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'rekening_keuangan_asal';
    protected $primaryKey = 'rekening_keuangan_asal_id';
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
        'keuangan_keluar_id',
        'rekening_bank_id',
        'jenis_rekening'
    ];

    public function keuangan_keluar()
    {
        return $this->belongsTo(KeuanganKeluar::class, 'keuangan_keluar_id', 'keuangan_keluar_id');
    }

    public function rekening_bank()
    {
        return $this->belongsTo(RekeningBank::class, 'rekening_bank_id', 'rekening_bank_id');
    }
}
