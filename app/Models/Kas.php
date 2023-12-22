<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Kas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'kas';
    protected $primaryKey = 'kas_id';
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
        'detail_jaminan_id',
        'kurs_mata_uang_id',
        'nilai',
        'kode_mata_uang',
        'nilai_penyesuaian',
        'keterangan',
    ];

    public function detail_jaminan()
    {
        return $this->belongsTo(DetailJaminan::class, 'detail_jaminan_id', 'detail_jaminan_id');
    }

    public function kurs_mata_uang()
    {
        return $this->belongsTo(KursMataUang::class, 'kurs_mata_uang_id', 'kurs_mata_uang_id');
    }
}
