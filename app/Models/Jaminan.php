<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Jaminan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'jaminan';
    protected $primaryKey = 'jaminan_id';
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
        'informasi_akun_id',
        'total_saldo_jaminan',
        'saldo_teralokasi',
        'saldo_tersedia',
    ];

    public function informasi_akun()
    {
        return $this->belongsTo(InformasiAkun::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function detail_jaminan()
    {
        return $this->hasMany(DetailJaminan::class, 'jaminan_id', 'jaminan_id');
    }

    public function pengeluaran_jaminan()
    {
        return $this->hasMany(PengeluaranJaminan::class, 'jaminan_id', 'jaminan_id');
    }
}
