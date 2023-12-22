<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Carousel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'carousel';
    protected $primaryKey = 'carousel_id';
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
        'aplikasi_id',
        'image_src',
        'title',
        'subtitle',
        'urutan',
        'page',
    ];

    public function aplikasi()
    {
        return $this->belongsTo(Aplikasi::class, 'aplikasi_id', 'aplikasi_id');
    }
}
