<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class StatusRegistrasiKomoditas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'status_registrasi_komoditas';
    protected $primaryKey = 'status_registrasi_komoditas_id';
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
        'nama_jenis'
    ];

    public function registrasi_komoditas()
    {
        return $this->hasMany(RegistrasiKomoditas::class, 'status_registrasi_komoditas_id', 'status_registrasi_komoditas_id');
    }
}
