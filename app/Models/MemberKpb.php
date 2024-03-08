<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class MemberKpb extends Model
{
    use HasFactory;

    protected $table = 'member_kpb';
    protected $primaryKey = 'member_kpb_id';
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
        'nik',
        'nama',
        'alamat',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'no_hp',
        'no_wa',
        'email',
        'password',
        'kode_pos',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'desa_id',
        'confirmed',
        'verified',
        'status',
        'is_member_lelang'
    ];
}
