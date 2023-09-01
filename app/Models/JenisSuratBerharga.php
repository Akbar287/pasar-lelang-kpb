<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class JenisSuratBerharga extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'jenis_surat_berharga';
    protected $primaryKey = 'jenis_surat_berharga_id';
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
        'keterangan'
    ];

    public function surat_berharga()
    {
        return $this->hasMany(SuratBerharga::class, 'jenis_surat_berharga_id', 'jenis_surat_berharga_id');
    }
}
