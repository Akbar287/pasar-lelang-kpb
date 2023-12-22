<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class NomorSurat extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'nomor_surat';
    protected $primaryKey = 'nomor_surat_id';
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
        'approval_lelang_id',
        'no_surat'
    ];

    public function approval_lelang()
    {
        return $this->belongsTo(ApprovalLelang::class, 'approval_lelang_id', 'approval_lelang_id');
    }

    public function waktu_penyerahan()
    {
        return $this->hasMany(WaktuPenyerahan::class, 'nomor_surat_id', 'nomor_surat_id');
    }
}
