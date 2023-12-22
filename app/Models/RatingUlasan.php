<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class RatingUlasan extends Model
{
    use HasFactory;
    protected $table = 'rating_ulasan';
    protected $primaryKey = 'rating_ulasan_id';
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
        'rating_detail_id',
        'keterangan'
    ];

    public function rating_detail()
    {
        return $this->belongsTo(RatingDetail::class, 'rating_detail_id', 'rating_detail_id');
    }
}
