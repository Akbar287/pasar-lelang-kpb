<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class StatusMember extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'status_member';
    protected $primaryKey = 'status_member_id';
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
        'nama_status',
        'keterangan'
    ];

    public function member()
    {
        return $this->hasMany(Member::class, 'status_member_id', 'status_member_id');
    }

    public function lembaga()
    {
        return $this->hasMany(Lembaga::class, 'status_member_id', 'status_member_id');
    }
}
