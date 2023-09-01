<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Lembaga extends Model
{
    use HasFactory;
    protected $table = 'lembaga';
    protected $primaryKey = 'lembaga_id';
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
        'informasi_akun_id',
        'status_member_id',
        'npwp_id',
        'nama_lembaga',
        'bidang_usaha',
        'is_aktif',
    ];

    public function informasi_akun()
    {
        return $this->belongsTo(InformasiAkun::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function npwp()
    {
        return $this->belongsTo(Npwp::class, 'npwp_id', 'npwp_id');
    }

    public function status_member()
    {
        return $this->belongsTo(StatusMember::class, 'status_member_id', 'status_member_id');
    }
}
