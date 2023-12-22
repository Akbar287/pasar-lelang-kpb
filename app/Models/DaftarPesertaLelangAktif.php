<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class DaftarPesertaLelangAktif extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'daftar_peserta_lelang_aktif';
    protected $primaryKey = 'daftar_peserta_lelang_aktif_id';
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
        'event_lelang_id',
        'lelang_id',
        'waktu_mulai',
        'waktu_selesai',
        'aktif'
    ];

    public function event_lelang()
    {
        return $this->belongsTo(EventLelang::class, 'event_lelang_id', 'event_lelang_id');
    }

    public function lelang()
    {
        return $this->belongsTo(Lelang::class, 'lelang_id', 'lelang_id');
    }
}
