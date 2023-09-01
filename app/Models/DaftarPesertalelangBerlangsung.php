<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class DaftarPesertalelangBerlangsung extends Model
{
    use HasFactory;
    protected $table = 'daftar_peserta_lelang_berlangsung';
    protected $primaryKey = 'daftar_peserta_lelang_berlangsung_id';
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
        'daftar_peserta_lelang_id',
        'lelang_id',
        'harga_ajuan',
        'waktu',
    ];

    public function daftar_peserta_lelang()
    {
        return $this->belongsTo(DaftarPesertaLelang::class, 'daftar_peserta_lelang_id', 'daftar_peserta_lelang_id');
    }

    public function approval_lelang()
    {
        return $this->belongsToMany(ApprovalLelang::class, 'daftar_peserta_lelang_berlangsung_approval', 'daftar_peserta_lelang_berlangsung_id', 'approval_lelang_id');
    }
}
