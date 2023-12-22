<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Ramsey\Uuid\Uuid;

class Userlogin extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes;
    protected $table = 'userlogin';
    protected $primaryKey = 'userlogin_id';
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
        'username',
        'password',
        'is_aktif',
        'access_token',
        'access',
        'last_login'
    ];

    public function informasi_akun()
    {
        return $this->belongsTo(InformasiAkun::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function operator_pasar_lelang()
    {
        return $this->hasOne(OperatorPasarLelang::class, 'userlogin_id', 'userlogin_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
