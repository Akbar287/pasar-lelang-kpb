<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class JenisVerifikasi extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'jenis_verifikasi';
    protected $primaryKey = 'jenis_verifikasi_id';
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
        'nama_verifikasi',
        'keterangan'
    ];

    public function verified_log()
    {
        return $this->hasMany(VerifiedLog::class, 'jenis_verifikasi_id', 'jenis_verifikasi_id');
    }
}
