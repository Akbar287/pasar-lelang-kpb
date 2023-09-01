<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class JenisKomoditas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'jenis_komoditas';
    protected $primaryKey = 'jenis_komoditas_id';
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
        'nama_jenis_komoditas',
        'keterangan',
        'is_aktif',
    ];

    public function komoditas()
    {
        return $this->hasMany(Komoditas::class, 'jenis_komoditas_id', 'jenis_komoditas_id');
    }
}
