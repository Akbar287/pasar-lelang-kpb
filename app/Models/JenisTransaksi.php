<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class JenisTransaksi extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'jenis_transaksi';
    protected $primaryKey = 'jenis_transaksi_id';
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
        'keterangan',
        'is_aktif',
    ];

    public function keuangan()
    {
        return $this->hasMany(Keuangan::class, 'jenis_transaksi_id', 'jenis_transaksi_id');
    }
}
