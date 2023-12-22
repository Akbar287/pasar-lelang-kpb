<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class DanaKeuangan extends Model
{
    use HasFactory;
    protected $table = 'dana_keuangan';
    protected $primaryKey = 'dana_keuangan_id';
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
        'verified_log_id',
        'rekening_pusat_id',
        'jenis',
        'jumlah_dana',
        'keterangan'
    ];

    public function verified_log()
    {
        return $this->belongsTo(VerifiedLog::class, 'verified_log_id', 'verified_log_id');
    }

    public function rekening_pusat()
    {
        return $this->belongsTo(RekeningPusat::class, 'rekening_pusat_id', 'rekening_pusat_id');
    }
}
