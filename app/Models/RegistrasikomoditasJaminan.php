<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class RegistrasikomoditasJaminan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'registrasi_komoditas_jaminan';
    protected $primaryKey = 'registrasi_komoditas_jaminan_id';
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
        'kadaluarsa',
        'kuantitas',
        'unit',
        'nilai_perkiraan',
        'haircut',
        'nilai_penyesuaian',
        'lokasi',
    ];

    public function detail_jaminan()
    {
        return $this->belongsTo(DetailJaminan::class, 'detail_jaminan_id', 'detail_jaminan_id');
    }
}
