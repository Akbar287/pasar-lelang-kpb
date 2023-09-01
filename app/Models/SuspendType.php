<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class SuspendType extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'suspend_type';
    protected $primaryKey = 'suspend_type_id';
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
        'nama_suspend',
        'keterangan',
    ];

    public function suspend()
    {
        return $this->hasMany(Suspend::class, 'suspend_type_id', 'suspend_type_id');
    }
}
