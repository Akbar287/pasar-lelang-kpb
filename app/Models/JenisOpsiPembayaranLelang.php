<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class JenisOpsiPembayaranLelang extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'jenis_opsi_pembayaran_lelang';
    protected $primaryKey = 'jenis_opsi_pembayaran_lelang_id';
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
        'nama_jenis',
    ];

    public function opsi_pembayaran_lelang()
    {
        return $this->hasMany(OpsiPembayaranLelang::class, 'jenis_opsi_pembayaran_lelang_id', 'jenis_opsi_pembayaran_lelang_id');
    }
}
