<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class PerubahanEventLelang extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'perubahan_event_lelang';
    protected $primaryKey = 'perubahan_event_lelang_id';
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
        'informasi_akun_id',
        'tanggal_perubahan'
    ];

    public function event_lelang()
    {
        return $this->belongsTo(EventLelang::class, 'event_lelang_id', 'event_lelang_id');
    }

    public function informasi_akun()
    {
        return $this->belongsTo(InformasiAkun::class, 'informasi_akun_id', 'informasi_akun_id');
    }
}
