<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Provinsi extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'provinsi';
    protected $primaryKey = 'provinsi_id';
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
        'nama_provinsi'
    ];

    public function kabupaten()
    {
        return $this->hasMany(Kabupaten::class, 'provinsi_id', 'provinsi_id');
    }
}
