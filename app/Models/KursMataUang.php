<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class KursMataUang extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'kurs_mata_uang';
    protected $primaryKey = 'kurs_mata_uang_id';
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
        'kode_mata_uang_asal',
        'mata_uang_asal',
        'kode_mata_uang_tujuan',
        'mata_uang_tujuan',
        'tanggal_update',
        'url_update'
    ];

    public function keuangan()
    {
        return $this->hasMany(Keuangan::class, 'kurs_mata_uang_id', 'kurs_mata_uang_id');
    }

    public function kas()
    {
        return $this->hasMany(Kas::class, 'kurs_mata_uang_id', 'kurs_mata_uang_id');
    }
}
