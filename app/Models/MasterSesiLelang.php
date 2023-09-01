<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class MasterSesiLelang extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'master_sesi_lelang';
    protected $primaryKey = 'master_sesi_lelang_id';
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
        'sesi',
        'jam_mulai',
        'jam_berakhir',
        'is_aktif'
    ];

    public function penyelenggara_pasar_lelang()
    {
        return $this->belongsTo(PenyelenggaraPasarLelang::class, 'penyelenggara_pasar_lelang_id', 'penyelenggara_pasar_lelang_id');
    }

    public function peserta_lelang()
    {
        return $this->hasMany(PesertaLelang::class, 'master_sesi_lelang_id', 'master_sesi_lelang_id');
    }

    public function lelang_sesi_online()
    {
        return $this->hasMany(LelangSesiOnline::class, 'master_sesi_lelang_id', 'master_sesi_lelang_id');
    }
}
