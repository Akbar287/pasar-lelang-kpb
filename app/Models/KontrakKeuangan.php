<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class KontrakKeuangan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'kontrak_keuangan';
    protected $primaryKey = 'kontrak_keuangan_id';
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
        'kontrak_id',
        'jaminan_lelang',
        'denda',
        'fee_penjual',
        'fee_pembeli'
    ];

    public function kontrak()
    {
        return $this->belongsTo(Kontrak::class, 'kontrak_id', 'kontrak_id');
    }
}
