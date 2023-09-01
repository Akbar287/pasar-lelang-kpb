<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class OperatorPasarLelang extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'operator_pasar_lelang';
    protected $primaryKey = 'operator_pasar_lelang_id';
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
        'offline_profile_id',
        'user_id',
        'nama_lengkap',
        'password',
        'is_aktif',
    ];

    public function offline_profile()
    {
        return $this->belongsTo(OfflineProfile::class, 'offline_profile_id', 'offline_profile_id');
    }
}
