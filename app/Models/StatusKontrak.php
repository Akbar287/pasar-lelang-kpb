<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class StatusKontrak extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'status_kontrak';
    protected $primaryKey = 'status_kontrak_id';
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

    public function kontrak()
    {
        return $this->hasMany(Kontrak::class, 'status_kontrak_id', 'status_kontrak_id');
    }
}
