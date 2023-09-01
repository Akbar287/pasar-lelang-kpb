<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class JaminanLelang extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'jaminan_lelang';
    protected $primaryKey = 'jaminan_lelang_id';
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
        'lelang_id',
        'nilai_jaminan',
        'total_jaminan',
        'is_jaminan',
    ];

    public function pengeluaran_jaminan()
    {
        return $this->belongsTo(PengeluaranJaminan::class, 'pengeluaran_jaminan_id', 'pengeluaran_jaminan_id');
    }

    public function lelang()
    {
        return $this->belongsTo(Lelang::class, 'lelang_id', 'lelang_id');
    }
}
