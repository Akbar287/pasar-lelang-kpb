<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Npwp extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'npwp';
    protected $primaryKey = 'npwp_id';
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
        'npwp'
    ];

    public function informasi_keuangan()
    {
        return $this->hasOne(InformasiKeuangan::class, 'npwp_id', 'npwp_id');
    }

    public function lembaga()
    {
        return $this->hasOne(Lembaga::class, 'npwp_id', 'npwp_id');
    }
}
