<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class JaminanKomoditas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'jaminan_komoditas';
    protected $primaryKey = 'jaminan_komoditas_id';
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
        'dokumen_settlement_id',
        'qty_jaminan',
        'nilai_jaminan',
        'komoditi',
        'qty_settlement',
        'alokasi_settlement',
    ];

    public function pengeluaran_jaminan()
    {
        return $this->belongsTo(PengeluaranJaminan::class, 'pengeluaran_jaminan_id', 'pengeluaran_jaminan_id');
    }

    public function dokumen_settlement()
    {
        return $this->belongsTo(DokumenSettlement::class, 'dokumen_settlement_id', 'dokumen_settlement_id');
    }
}
