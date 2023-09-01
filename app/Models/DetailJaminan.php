<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class DetailJaminan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'detail_jaminan';
    protected $primaryKey = 'detail_jaminan_id';
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
        'jaminan_id',
        'tanggal_transaksi',
        'nilai_jaminan',
        'nilai_penyesuaian',
        'is_aktif',
    ];

    public function jaminan()
    {
        return $this->belongsTo(Jaminan::class, 'jaminan_id', 'jaminan_id');
    }

    public function surat_berharga()
    {
        return $this->hasMany(SuratBerharga::class, 'detail_jaminan_id', 'detail_jaminan_id');
    }
    public function kas()
    {
        return $this->hasMany(Kas::class, 'detail_jaminan_id', 'detail_jaminan_id');
    }
    public function registrasi_komoditas_jaminan()
    {
        return $this->hasMany(RegistrasikomoditasJaminan::class, 'detail_jaminan_id', 'detail_jaminan_id');
    }
}
