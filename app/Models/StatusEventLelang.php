<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class StatusEventLelang extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'status_event_lelang';
    protected $primaryKey = 'status_event_lelang_id';
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
        'icon',
        'urutan',
        'is_aktif',
        'keterangan',
    ];

    public function event_lelang()
    {
        return $this->hasMany(EventLelang::class, 'status_event_lelang_id', 'status_event_lelang_id');
    }
}
