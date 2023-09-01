<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class DokumenMember extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'dokumen_member';
    protected $primaryKey = 'dokumen_member_id';
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
        'jenis_dokumen_id',
        'informasi_akun_id',
        'versi_unggah',
        'tanggal_unggah',
        'nama_dokumen',
        'nama_file',
    ];

    public function informasi_akun()
    {
        return $this->belongsTo(InformasiAkun::class, 'informasi_akun_id', 'informasi_akun_id');
    }

    public function jenis_dokumen()
    {
        return $this->belongsTo(JenisDokumen::class, 'jenis_dokumen_id', 'jenis_dokumen_id');
    }
}
