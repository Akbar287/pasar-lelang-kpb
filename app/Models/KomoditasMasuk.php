<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class KomoditasMasuk extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'komoditas_masuk';
    protected $primaryKey = 'komoditas_masuk_id';
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
        'pembayaran_lelang_id',
        'tanggal_instruksi',
        'no_instruksi',
        'no_faktur',
        'status',
    ];

    public function pembayaran_lelang()
    {
        return $this->belongsTo(PembayaranLelang::class, 'pembayaran_lelang_id', 'pembayaran_lelang_id');
    }
}
