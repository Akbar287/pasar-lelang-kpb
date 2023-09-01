<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class PesertaLelangBerlangsung extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'peserta_lelang_berlangsung';
    protected $primaryKey = 'peserta_lelang_berlangsung_id';
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
        'lelang_id',
        'peserta_lelang_id',
        'waktu',
        'harga_ajuan'
    ];

    public function peserta_lelang()
    {
        return $this->belongsTo(PesertaLelang::class, 'peserta_lelang_id', 'peserta_lelang_id');
    }

    public function approval_lelang()
    {
        return $this->hasOne(ApprovalLelang::class, 'peserta_lelang_berlangsung_id', 'peserta_lelang_berlangsung_id');
    }

    public function lelang()
    {
        return $this->belongsTo(Lelang::class, 'lelang_id', 'lelang_id');
    }

    public function peserta_lelang_berlangsung()
    {
        return $this->belongsToMany(PesertalelangBerlangsung::class, 'peserta_lelang_berlangsung_approval', 'peserta_lelang_berlangsung_id', 'approval_lelang_id');
    }
}
