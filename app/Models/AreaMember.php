<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class AreaMember extends Model
{
    use HasFactory;

    protected $table = 'area_member';
    protected $primaryKey = 'area_member_id';
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
        'desa_id',
        'kode_pos',
        'alamat',
        'alamat_ke',
    ];

    public function informasi_akun()
    {
        return $this->belongsToMany(InformasiAkun::class, 'area_member_informasi_akun', 'area_member_id', 'informasi_akun_id');
    }

    public function lembaga()
    {
        return $this->hasOne(Lembaga::class, 'area_member_id', 'area_member_id');
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'desa_id', 'desa_id');
    }
}
