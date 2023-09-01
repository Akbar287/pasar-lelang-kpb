<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Komoditas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'komoditas';
    protected $primaryKey = 'komoditas_id';
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
        'jenis_komoditas_id',
        'nama_komoditas',
        'satuan_ukuran',
        'inisiasi',
        'kadaluarsa',
    ];

    public function jenis_komoditas()
    {
        return $this->belongsTo(JenisKomoditas::class, 'jenis_komoditas_id', 'jenis_komoditas_id');
    }

    public function kontrak()
    {
        return $this->hasMany(Kontrak::class, 'komoditas_id', 'komoditas_id');
    }

    public function registrasi_komoditas()
    {
        return $this->hasMany(RegistrasiKomoditas::class, 'komoditas_id', 'komoditas_id');
    }
}
