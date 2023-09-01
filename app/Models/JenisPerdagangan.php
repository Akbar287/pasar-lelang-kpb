<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class JenisPerdagangan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'jenis_perdagangan';
    protected $primaryKey = 'jenis_perdagangan_id';
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
        'nama_perdagangan',
        'keterangan',
        'is_aktif',
    ];

    public function kontrak()
    {
        return $this->hasMany(Kontrak::class, 'jenis_perdagangan_id', 'jenis_perdagangan_id');
    }

    public function lelang()
    {
        return $this->hasMany(Lelang::class, 'jenis_perdagangan_id', 'jenis_perdagangan_id');
    }
}
