<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Admin extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'admin';
    protected $primaryKey = 'admin_id';
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
        'is_aktif',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    public function verified_log()
    {
        return $this->hasMany(VerifiedLog::class, 'admin_id', 'admin_id');
    }

    public function penyelenggara_pasar_lelang()
    {
        return $this->hasMany(PenyelenggaraPasarLelang::class, 'admin_id', 'admin_id');
    }
}
