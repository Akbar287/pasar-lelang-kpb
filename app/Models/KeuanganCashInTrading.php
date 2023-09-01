<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class KeuanganCashInTrading extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'keuangan_cash_in_trading';
    protected $primaryKey = 'keuangan_cash_in_trading_id';
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
        'keuangan_id',
        'saldo_belum_teralokasi',
        'nomor_instruksi',
        'jenis_alokasi',
        'sisa_alokasi',
        'alokasi_collateral',
        'alokasi_penyelesaian',
        'alokasi_lain',
    ];

    public function keuangan()
    {
        return $this->belongsTo(Keuangan::class, 'keuangan_id', 'keuangan_id');
    }
}
