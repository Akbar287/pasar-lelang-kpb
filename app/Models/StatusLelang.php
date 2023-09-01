<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class StatusLelang extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'status_lelang';
    protected $primaryKey = 'status_lelang_id';
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
        'nama_status'
    ];
    public function status_lelang_pivot()
    {
        return $this->hasMany(StatusLelangPivot::class, 'status_lelang_id', 'status_lelang_id');
    }

    public function lelang()
    {
        return $this->belongsToMany(Lelang::class, 'status_lelang_pivot', 'status_lelang_id', 'lelang_id');
    }
}
