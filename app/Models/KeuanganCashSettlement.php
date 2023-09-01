<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class KeuanganCashSettlement extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'keuangan_cash_settlement';
    protected $primaryKey = 'keuangan_cash_settlement_id';
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
        'rekening_bank_id',
    ];

    public function keuangan()
    {
        return $this->belongsTo(Keuangan::class, 'keuangan_id', 'keuangan_id');
    }

    public function rekening_bank()
    {
        return $this->belongsTo(RekeningBank::class, 'rekening_bank_id', 'rekening_bank_id');
    }
}
