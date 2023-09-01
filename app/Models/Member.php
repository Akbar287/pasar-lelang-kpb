<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Member extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'member';
    protected $primaryKey = 'member_id';
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
        'status_member_id',
        'informasi_akun_id'
    ];

    public function status_member()
    {
        return $this->belongsTo(StatusMember::class, 'status_member_id', 'status_member_id');
    }

    public function ktp()
    {
        return $this->hasOne(Ktp::class, 'member_id', 'member_id');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'member_id', 'member_id');
    }

    public function verified_log()
    {
        return $this->hasMany(VerifiedLog::class, 'member_id', 'member_id');
    }

    public function userlogin()
    {
        return $this->hasOne(Userlogin::class, 'member_id', 'member_id');
    }

    public function setting_collateral()
    {
        return $this->hasMany(SettingCollateral::class, 'member_id', 'member_id');
    }

    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_member', 'member_id', 'role_id');
    }

    public function lembaga_informasi_pic()
    {
        return $this->hasMany(LembagaInformasiPic::class, 'member_id', 'member_id');
    }

    public function informasi_akun()
    {
        return $this->belongsTo(InformasiAkun::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function informasi_keuangan()
    {
        return $this->hasOne(InformasiKeuangan::class, 'member_id', 'member_id');
    }
}
