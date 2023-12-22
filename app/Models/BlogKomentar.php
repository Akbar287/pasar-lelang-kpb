<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class BlogKomentar extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'blog_komentar';
    protected $primaryKey = 'blog_komentar_id';
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
        'title',
        'content',
    ];

    public function blog_post()
    {
        return $this->belongsTo(BlogPost::class, 'blog_post_id', 'blog_post_id');
    }
}
