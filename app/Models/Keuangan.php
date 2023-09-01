<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Keuangan extends Model
{
    use HasFactory;
    protected $table = 'keuangan';
    protected $primaryKey = 'keuangan_id';
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
        'rekening_bank_id',
        'jenis_transaksi_id',
        'kurs_mata_uang_id',
        'jumlah',
        'keterangan',
    ];

    public function rekening_bank()
    {
        return $this->belongsTo(RekeningBank::class, 'rekening_bank_id', 'rekening_bank_id');
    }

    public function jenis_transaksi()
    {
        return $this->belongsTo(JenisTransaksi::class, 'jenis_transaksi_id', 'jenis_transaksi_id');
    }

    public function kurs_mata_uang()
    {
        return $this->belongsTo(KursMataUang::class, 'kurs_mata_uang_id', 'kurs_mata_uang_id');
    }

    public function verified_log()
    {
        return $this->belongsToMany(VerifiedLog::class, 'keuangan_verified_log', 'keuangan_id', 'verified_log_id');
    }

    public function keuangan_cash_in_trading()
    {
        return $this->hasMany(KeuanganCashInTrading::class, 'keuangan_id', 'keuangan_id');
    }

    public function keuangan_cash_non_trading()
    {
        return $this->hasMany(KeuanganCashNonTrading::class, 'keuangan_id', 'keuangan_id');
    }

    public function keuangan_cash_settlement()
    {
        return $this->hasMany(KeuanganCashSettlement::class, 'keuangan_id', 'keuangan_id');
    }

    public function keuangan_cash_pengembalian_collateral()
    {
        return $this->hasMany(KeuanganPengembalianCollateral::class, 'keuangan_id', 'keuangan_id');
    }
}
