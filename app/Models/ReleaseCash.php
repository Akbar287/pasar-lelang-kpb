<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class ReleaseCash extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'release_cash';
    protected $primaryKey = 'release_cash_id';
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
        'pengeluaran_jaminan_id',
        'jumlah',
    ];

    public function pengeluaran_jaminan()
    {
        return $this->belongsTo(PengeluaranJaminan::class, 'pengeluaran_jaminan_id', 'pengeluaran_jaminan_id');
    }

    public function dokumen_settlement()
    {
        return $this->belongsToMany(DokumenSettlement::class, 'release_cash_dokumen_settlement', 'release_cash_id', 'dokumen_settlement_id');
    }
}
