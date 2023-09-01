<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class EventLelang extends Model
{
    use HasFactory;
    protected $table = 'event_lelang';
    protected $primaryKey = 'event_lelang_id';
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
        'status_event_lelang_id',
        'event_kode',
        'nama_lelang',
        'tanggal_lelang',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'ketua_lelang',
        'waktu_sinkronisasi',
        'keterangan',
        'status_pendaftaran',
        'is_open',
        'is_online',
    ];

    public function offline_profile()
    {
        return $this->belongsTo(OfflineProfile::class, 'offline_profile_id', 'offline_profile_id');
    }

    public function daftar_peserta_lelang()
    {
        return $this->hasMany(DaftarPesertaLelang::class, 'event_lelang_id', 'event_lelang_id');
    }

    public function perubahan_event_lelang()
    {
        return $this->hasMany(PerubahanEventLelang::class, 'event_lelang_id', 'event_lelang_id');
    }

    public function lelang()
    {
        return $this->belongsToMany(Lelang::class, 'event_lelang_relation', 'event_lelang_id', 'lelang_id');
    }

    public function status_event_lelang()
    {
        return $this->belongsTo(StatusEventLelang::class, 'status_event_lelang_id', 'status_event_lelang_id');
    }
}
