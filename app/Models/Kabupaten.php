<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Kabupaten extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'kabupaten';
    protected $primaryKey = 'kabupaten_id';
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
        'provinsi_id',
        'nama_kabupaten'
    ];

    public function provinsi()
    {
        return $this->belongsTo(provinsi::class, 'provinsi_id', 'provinsi_id');
    }

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class, 'kabupaten_id', 'kabupaten_id');
    }
}
