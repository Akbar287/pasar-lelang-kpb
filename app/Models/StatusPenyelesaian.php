<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class StatusPenyelesaian extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'status_penyelesaian';
    protected $primaryKey = 'status_penyelesaian_id';
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
        'nama_jenis'
    ];

    public function pembayaran_lelang()
    {
        return $this->hasMany(PembayaranLelang::class, 'status_penyelesaian_id', 'status_penyelesaian_id');
    }
}
