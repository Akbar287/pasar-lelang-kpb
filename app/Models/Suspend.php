<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Suspend extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'suspend';
    protected $primaryKey = 'suspend_id';
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
        'verified_log_id',
        'suspend_type_id',
        'suspend_kode',
        'tanggal_suspend',
        'tanggal_reaktivasi'
    ];

    public function suspend_type()
    {
        return $this->belongsTo(SuspendType::class, 'suspend_type_id', 'suspend_type_id');
    }

    public function verified_log()
    {
        return $this->hasMany(VerifiedLog::class, 'verified_log_id', 'verified_log_id');
    }
}
