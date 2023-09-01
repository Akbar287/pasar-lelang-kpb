<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class LelangVerifiedSesi extends Model
{
    use HasFactory;
    protected $table = 'lelang_verified_sesi';
    protected $primaryKey = 'lelang_verified_sesi_id';
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
        'lelang_id',
        'verified_log_id',
    ];

    public function lelang()
    {
        return $this->belongsTo(Lelang::class, 'lelang_id', 'lelang_id');
    }

    public function verified_log()
    {
        return $this->belongsTo(VerifiedLog::class, 'verified_log_id', 'verified_log_id');
    }
}
