<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Role extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'role';
    protected $primaryKey = 'role_id';
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
        'nama_role',
        'keterangan',
        'is_aktif'
    ];

    public function jenis_dokumen()
    {
        return $this->belongsToMany(JenisDokumen::class, 'jenis_dokumen_member_role', 'role_id', 'jenis_dokumen_id');
    }

    public function member()
    {
        return $this->belongsToMany(Member::class, 'role_member', 'role_id', 'member_id');
    }
}
