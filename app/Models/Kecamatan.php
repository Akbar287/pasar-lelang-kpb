<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Kecamatan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'kecamatan';
    protected $primaryKey = 'kecamatan_id';
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
        'kabupaten_id',
        'nama_kecamatan'
    ];

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id', 'kabupaten_id');
    }

    public function desa()
    {
        return $this->hasMany(Desa::class, 'kecamatan_id', 'kecamatan_id');
    }
}
