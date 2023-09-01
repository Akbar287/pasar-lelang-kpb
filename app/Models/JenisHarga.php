<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class JenisHarga extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'jenis_harga';
    protected $primaryKey = 'jenis_harga_id';
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
        'nama_jenis_harga'
    ];

    public function lelang()
    {
        return $this->hasMany(Lelang::class, 'jenis_harga_id', 'jenis_harga_id');
    }
}
