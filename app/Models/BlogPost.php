<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class BlogPost extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'blog_post';
    protected $primaryKey = 'blog_post_id';
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
        'admin_id',
        'title',
        'slug',
        'summary',
        'content',
        'published',
        'published_at'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }

    public function blog_tag()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tag', 'blog_post_id', 'blog_tag_id');
    }

    public function blog_kategori()
    {
        return $this->belongsToMany(BlogKategori::class, 'blog_post_kategori', 'blog_post_id', 'blog_kategori_id');
    }

    public function blog_statistik()
    {
        return $this->hasOne(BlogStatistik::class, 'blog_post_id', 'blog_post_id');
    }

    public function blog_komentar()
    {
        return $this->hasMany(BlogKomentar::class, 'blog_post_id', 'blog_post_id');
    }

    public function blog_post_meta()
    {
        return $this->hasMany(BlogPostMeta::class, 'blog_post_id', 'blog_post_id');
    }
}
