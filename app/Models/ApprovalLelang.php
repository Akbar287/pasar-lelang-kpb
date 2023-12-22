<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class ApprovalLelang extends Model
{
    use HasFactory;
    protected $table = 'approval_lelang';
    protected $primaryKey = 'approval_lelang_id';
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
        'jenis_harga_id',
        'lelang_id',
        'harga_pemenang'
    ];

    public function informasi_akun()
    {
        return $this->belongsTo(InformasiAkun::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function jenis_harga()
    {
        return $this->belongsTo(JenisHarga::class, 'jenis_harga_id', 'jenis_harga_id');
    }

    public function nomor_surat()
    {
        return $this->hasOne(NomorSurat::class, 'approval_lelang_id', 'approval_lelang_id');
    }

    public function lelang()
    {
        return $this->belongsTo(Lelang::class, 'lelang_id', 'lelang_id');
    }

    public function pembayaran_lelang()
    {
        return $this->hasOne(PembayaranLelang::class, 'approval_lelang_id', 'approval_lelang_id');
    }

    public function daftar_peserta_lelang_berlangsung()
    {
        return $this->belongsToMany(DaftarPesertalelangBerlangsung::class, 'daftar_peserta_lelang_berlangsung_approval', 'approval_lelang_id', 'daftar_peserta_lelang_berlangsung_id');
    }

    public function peserta_lelang_berlangsung()
    {
        return $this->belongsToMany(PesertalelangBerlangsung::class, 'peserta_lelang_berlangsung_approval', 'approval_lelang_id', 'peserta_lelang_berlangsung_id');
    }
}
