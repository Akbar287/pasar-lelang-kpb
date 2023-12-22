<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Bank extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'bank';
    protected $primaryKey = 'bank_id';
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
        'kode_bank',
        'nama_bank',
        'logo',
    ];

    public function rekening_bank()
    {
        return $this->hasMany(RekeningBank::class, 'bank_id', 'bank_id');
    }

    public function rekening_pusat()
    {
        return $this->hasMany(RekeningPusat::class, 'bank_id', 'bank_id');
    }
}
