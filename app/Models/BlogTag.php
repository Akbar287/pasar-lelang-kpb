<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class BlogTag extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'blog_tag';
    protected $primaryKey = 'blog_tag_id';
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
        'title',
        'slug',
        'content'
    ];

    public function blog_post()
    {
        return $this->belongsToMany(BlogPost::class, 'blog_post_tag', 'blog_tag_id', 'blog_post_id');
    }
}
