<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Desa extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'desa';
    protected $primaryKey = 'desa_id';
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
        'kecamatan_id',
        'nama_desa'
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'kecamatan_id');
    }

    public function area_member()
    {
        return $this->hasMany(AreaMember::class, 'desa_id', 'desa_id');
    }
}
