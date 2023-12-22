<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class PenyelenggaraPasarLelang extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'penyelenggara_pasar_lelang';
    protected $primaryKey = 'penyelenggara_pasar_lelang_id';
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
        'admin_id'
    ];

    public function master_sesi_lelang()
    {
        return $this->hasMany(MasterSesiLelang::class, 'penyelenggara_pasar_lelang_id', 'penyelenggara_pasar_lelang_id');
    }

    public function gudang()
    {
        return $this->hasMany(Gudang::class, 'penyelenggara_pasar_lelang_id', 'penyelenggara_pasar_lelang_id');
    }

    public function kontrak()
    {
        return $this->hasMany(Kontrak::class, 'penyelenggara_pasar_lelang_id', 'penyelenggara_pasar_lelang_id');
    }

    public function offline_profile()
    {
        return $this->hasMany(OfflineProfile::class, 'penyelenggara_pasar_lelang_id', 'penyelenggara_pasar_lelang_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }
}
