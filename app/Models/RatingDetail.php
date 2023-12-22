<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class RatingDetail extends Model
{
    use HasFactory;
    protected $table = 'rating_detail';
    protected $primaryKey = 'rating_detail_id';
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
        'rating_id',
        'informasi_akun_id',
        'lelang_id',
        'star',
        'secret'
    ];

    public function rating()
    {
        return $this->belongsTo(Rating::class, 'rating_id', 'rating_id');
    }

    public function informasi_akun()
    {
        return $this->belongsTo(InformasiAkun::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function lelang()
    {
        return $this->belongsTo(Lelang::class, 'lelang_id', 'lelang_id');
    }

    public function rating_ulasan()
    {
        return $this->hasOne(RatingUlasan::class, 'rating_detail_id', 'rating_detail_id');
    }
}
