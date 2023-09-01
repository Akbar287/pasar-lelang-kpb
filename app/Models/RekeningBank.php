<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class RekeningBank extends Model
{
    use HasFactory;
    protected $table = 'rekening_bank';
    protected $primaryKey = 'rekening_bank_id';
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
        'informasi_akun_id',
        'bank_id',
        'nomor_rekening',
        'nama_pemilik',
        'cabang',
        'mata_uang',
        'nilai_awal',
        'saldo',
    ];

    public function informasi_akun()
    {
        return $this->belongsTo(InformasiAkun::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function keuangan()
    {
        return $this->hasMany(Keuangan::class, 'rekening_bank_id', 'rekening_bank_id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'bank_id');
    }

    public function rekening_keuangan_asal()
    {
        return $this->hasMany(RekeningKeuanganAsal::class, 'rekening_bank_id', 'rekening_bank_id');
    }

    public function keuangan_cash_settlement()
    {
        return $this->hasMany(KeuanganCashSettlement::class, 'rekening_bank_id', 'rekening_bank_id');
    }

    public function keuangan_cash_pengembalian_collateral()
    {
        return $this->hasMany(KeuanganPengembalianCollateral::class, 'rekening_bank_id', 'rekening_bank_id');
    }
}
