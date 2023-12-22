<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class PengeluaranJaminan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'pengeluaran_jaminan';
    protected $primaryKey = 'pengeluaran_jaminan_id';
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
        'jaminan_id',
        'jenis_pengeluaran_jaminan_id',
        'kode_transaksi',
        'tanggal',
        'is_aktif',
        'jumlah',
        'keterangan',
    ];

    public function jaminan()
    {
        return $this->belongsTo(Jaminan::class, 'jaminan_id', 'jaminan_id');
    }

    public function jenis_pengeluaran_jaminan()
    {
        return $this->belongsTo(JenisPengeluaranJaminan::class, 'jenis_pengeluaran_jaminan_id', 'jenis_pengeluaran_jaminan_id');
    }

    public function release_cash()
    {
        return $this->hasOne(ReleaseCash::class, 'pengeluaran_jaminan_id', 'pengeluaran_jaminan_id');
    }

    public function return_cash()
    {
        return $this->hasOne(ReturnCash::class, 'pengeluaran_jaminan_id', 'pengeluaran_jaminan_id');
    }

    public function jaminan_komoditas()
    {
        return $this->hasMany(JaminanKomoditas::class, 'pengeluaran_jaminan_id', 'pengeluaran_jaminan_id');
    }

    public function jaminan_lelang()
    {
        return $this->hasOne(JaminanLelang::class, 'pengeluaran_jaminan_id', 'pengeluaran_jaminan_id');
    }

    public function verified_log()
    {
        return $this->belongsToMany(VerifiedLog::class, 'pengeluaran_jaminan_verified_log', 'pengeluaran_jaminan_id', 'verified_log_id');
    }
}
