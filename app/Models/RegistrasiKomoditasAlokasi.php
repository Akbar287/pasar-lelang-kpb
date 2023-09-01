<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class RegistrasiKomoditasAlokasi extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'registrasi_komoditas_alokasi';
    protected $primaryKey = 'registrasi_komoditas_alokasi_id';
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
        'registrasi_komoditas_id',
        'sisa_alokasi_saldo',
        'saldo_belum_teralokasi',
        'alokasi_kolateral',
        'alokasi_penyelesaian',
        'alokasi_lain',
        'type_alokasi'
    ];

    public function registrasi_komoditas()
    {
        return $this->belongsTo(RegistrasiKomoditas::class, 'registrasi_komoditas_id', 'registrasi_komoditas_id');
    }
}
