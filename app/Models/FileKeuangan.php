<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class FileKeuangan extends Model
{
    use HasFactory;
    protected $table = 'file_keuangan';
    protected $primaryKey = 'file_keuangan_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }
    protected $fillable = [
        'keuangan_id',
        'nama_dokumen',
        'nama_file',
        'tanggal_upload'
    ];

    public function keuangan()
    {
        return $this->belongsTo(Keuangan::class, 'keuangan_id', 'keuangan_id');
    }
}
