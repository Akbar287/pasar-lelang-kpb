<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class PesertaLelang extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'peserta_lelang';
    protected $primaryKey = 'peserta_lelang_id';
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
        'mater_sesi_lelang_id',
        'tanggal',
        'kode_peserta_lelang',
    ];

    public function master_sesi_lelang()
    {
        return $this->belongsTo(MasterSesiLelang::class, 'master_sesi_lelang_id', 'master_sesi_lelang_id');
    }

    public function informasi_akun()
    {
        return $this->belongsTo(InformasiAkun::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function peserta_lelang_berlangsung()
    {
        return $this->hasMany(PesertaLelangBerlangsung::class, 'peserta_lelang_id', 'peserta_lelang_id');
    }
}
