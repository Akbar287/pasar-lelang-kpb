<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class InformasiAkun extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'informasi_akun';
    protected $primaryKey = 'informasi_akun_id';
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
        'email',
        'no_hp',
        'no_wa',
        'no_fax',
        'avatar',
    ];

    public function area_member()
    {
        return $this->belongsToMany(AreaMember::class, 'area_member_informasi_akun', 'informasi_akun_id', 'area_member_id');
    }

    public function lembaga()
    {
        return $this->hasOne(Lembaga::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function member()
    {
        return $this->hasOne(Member::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function rekening_bank()
    {
        return $this->hasMany(RekeningBank::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function dokumen_member()
    {
        return $this->hasMany(DokumenMember::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function userlogin()
    {
        return $this->hasMany(Userlogin::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function verified_log()
    {
        return $this->hasMany(VerifiedLog::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function kontrak()
    {
        return $this->hasMany(Kontrak::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function peserta_lelang()
    {
        return $this->hasMany(PesertaLelang::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function approval_lelang()
    {
        return $this->hasMany(ApprovalLelang::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function daftar_peserta_lelang()
    {
        return $this->hasMany(DaftarPesertaLelang::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function perubahan_event_lelang()
    {
        return $this->hasMany(PerubahanEventLelang::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function registrasi_komoditas()
    {
        return $this->hasMany(RegistrasiKomoditas::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function dokumen_settlement()
    {
        return $this->belongsToMany(DokumenSettlement::class, 'dokumen_settlement_member', 'informasi_akun_id', 'dokumen_settlement_id');
    }

    public function jaminan()
    {
        return $this->hasMany(Jaminan::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function opsi_pembayaran_lelang()
    {
        return $this->hasMany(OpsiPembayaranLelang::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function rating()
    {
        return $this->hasOne(Rating::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function rating_detail()
    {
        return $this->hasMany(RatingDetail::class, 'informasi_akun_id', 'informasi_akun_id');
    }
}
