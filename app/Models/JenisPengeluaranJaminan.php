<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class JenisPengeluaranJaminan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'jenis_pengeluaran_jaminan';
    protected $primaryKey = 'jenis_pengeluaran_jaminan_id';
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
        'nama_jenis'
    ];

    public function pengeluaran_jaminan()
    {
        return $this->hasMany(PengeluaranJaminan::class, 'jenis_pengeluaran_jaminan_id', 'jenis_pengeluaran_jaminan_id');
    }
}
