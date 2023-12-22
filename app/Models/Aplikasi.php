<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Aplikasi extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'aplikasi';
    protected $primaryKey = 'aplikasi_id';
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
        'nama_aplikasi',
        'header_description',
        'footer_description',
        'img_welcome',
    ];

    public function web_link()
    {
        return $this->hasMany(WebLink::class, 'aplikasi_id', 'aplikasi_id');
    }

    public function carousel()
    {
        return $this->hasMany(Carousel::class, 'aplikasi_id', 'aplikasi_id');
    }
}
