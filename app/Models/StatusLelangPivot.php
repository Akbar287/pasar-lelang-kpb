<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class StatusLelangPivot extends Model
{
    use HasFactory;
    protected $table = 'status_lelang_pivot';
    protected $primaryKey = 'status_lelang_pivot_id';
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
        'status_lelang_id',
        'is_aktif'
    ];

    public function lelang()
    {
        return $this->belongsTo(Lelang::class, 'lelang_id', 'lelang_id');
    }

    public function status_lelang()
    {
        return $this->belongsTo(StatusLelang::class, 'status_lelang_id', 'status_lelang_id');
    }
}
