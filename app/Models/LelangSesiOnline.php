<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class LelangSesiOnline extends Model
{
    use HasFactory;
    protected $table = 'lelang_sesi_online';
    protected $primaryKey = 'lelang_sesi_online_id';
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
        'master_sesi_lelang_id',
        'tanggal',
        'is_verification_admin',
    ];

    public function master_sesi_lelang()
    {
        return $this->belongsTo(MasterSesiLelang::class, 'master_sesi_lelang_id', 'master_sesi_lelang_id');
    }

    public function master_sesi_online()
    {
        return $this->belongsTo(MasterSesiLelang::class, 'master_sesi_lelang_id', 'master_sesi_lelang_id');
    }

    public function lelang()
    {
        return $this->belongsTo(Lelang::class, 'lelang_id', 'lelang_id');
    }
}
