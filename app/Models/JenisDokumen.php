<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class JenisDokumen extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'jenis_dokumen';
    protected $primaryKey = 'jenis_dokumen_id';
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
        'nama_jenis',
        'keterangan',
    ];

    public function role()
    {
        return $this->belongsToMany(Role::class, 'jenis_dokumen_member_role', 'jenis_dokumen_id', 'role_id');
    }

    public function dokumen_member()
    {
        return $this->hasMany(DokumenMember::class, 'jenis_dokumen_id', 'jenis_dokumen_id');
    }
}
