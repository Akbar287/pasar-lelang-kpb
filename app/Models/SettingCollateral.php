<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class SettingCollateral extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'setting_collateral';
    protected $primaryKey = 'setting_collateral_id';
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
        'member_id',
        'jenis_inisiasi_id',
        'is_aktif'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    public function jenis_inisiasi()
    {
        return $this->belongsTo(JenisInisiasi::class, 'jenis_inisiasi_id', 'jenis_inisiasi_id');
    }
}
