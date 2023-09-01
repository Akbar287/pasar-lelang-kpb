<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Gudang extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'gudang';
    protected $primaryKey = 'gudang_id';
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
        'penyelenggara_pasar_lelang_id',
        'gudang_kode',
        'nama_gudang',
        'contact_person',
        'contact_number',
        'nama_pengelola',
        'keterangan',
        'alamat',
    ];

    public function registrasi_komoditas()
    {
        return $this->hasMany(RegistrasiKomoditas::class, 'gudang_id', 'gudang_id');
    }

    public function penyelenggara_pasar_lelang()
    {
        return $this->belongsTo(PenyelenggaraPasarLelang::class, 'penyelenggara_pasar_lelang_id', 'penyelenggara_pasar_lelang_id');
    }
}
