<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class PesertaLelangAktif extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'peserta_lelang_aktif';
    protected $primaryKey = 'peserta_lelang_aktif_id';
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
        'master_sesi_lelang_id',
        'lelang_sesi_online_id',
        'lelang_id',
        'waktu_mulai',
        'waktu_selesai',
        'aktif'
    ];

    public function master_sesi_lelang()
    {
        return $this->belongsTo(MasterSesiLelang::class, 'master_sesi_lelang_id', 'master_sesi_lelang_id');
    }

    public function lelang_sesi_online()
    {
        return $this->belongsTo(LelangSesiOnline::class, 'lelang_sesi_online_id', 'lelang_sesi_online_id');
    }

    public function lelang()
    {
        return $this->belongsTo(Lelang::class, 'lelang_id', 'lelang_id');
    }
}
