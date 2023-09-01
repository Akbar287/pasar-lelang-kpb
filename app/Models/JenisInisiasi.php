<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class JenisInisiasi extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'jenis_inisiasi';
    protected $primaryKey = 'jenis_inisiasi_id';
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
        'nama_inisiasi',
        'keterangan',
        'is_aktif',
    ];

    public function lelang()
    {
        return $this->hasMany(Lelang::class, 'jenis_inisiasi_id', 'jenis_inisiasi_id');
    }

    public function setting_collateral()
    {
        return $this->hasMany(SettingCollateral::class, 'jenis_inisiasi_id', 'jenis_inisiasi_id');
    }
}
