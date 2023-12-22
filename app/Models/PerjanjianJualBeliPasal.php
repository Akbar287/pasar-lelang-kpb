<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class PerjanjianJualBeliPasal extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'perjanjian_jual_beli_pasal';
    protected $primaryKey = 'perjanjian_jual_beli_pasal_id';
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
        'key',
        'value'
    ];
}
