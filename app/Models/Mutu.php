<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Mutu extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'mutu';
    protected $primaryKey = 'mutu_id';
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
        'nama_mutu',
        'keterangan',
        'is_aktif'
    ];

    public function registrasi_komoditas()
    {
        return $this->hasMany(RegistrasiKomoditas::class, 'mutu_id', 'mutu_id');
    }

    public function kontrak()
    {
        return $this->hasMany(Kontrak::class, 'mutu_id', 'mutu_id');
    }
}
