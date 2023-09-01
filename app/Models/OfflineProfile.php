<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class OfflineProfile extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'offline_profile';
    protected $primaryKey = 'offline_profile_id';
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
        'registrasi_id',
        'nama_profile',
        'is_open',
        'tanggal_register',
        'keterangan'
    ];

    public function event_lelang()
    {
        return $this->hasMany(EventLelang::class, 'offline_profile_id', 'offline_profile_id');
    }

    public function operator_pasar_lelang()
    {
        return $this->hasMany(OperatorPasarLelang::class, 'offline_profile_id', 'offline_profile_id');
    }
}
