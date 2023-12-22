<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class BlogStatistik extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'blog_statistik';
    protected $primaryKey = 'blog_statistik_id';
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
        'blog_post_id',
        'visited'
    ];

    public function blog_post()
    {
        return $this->belongsTo(BlogPost::class, 'blog_post_id', 'blog_post_id');
    }
}
