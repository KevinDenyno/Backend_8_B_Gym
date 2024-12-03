<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Personal_trainer extends Model
{
    use HasFactory;

    protected $table = 'personal_trainer';
    protected $primaryKey = 'id_trainer';

    protected $fillable = [
        'rating_trainer',
        'id_trainer' // Kita akan mengisi ini berdasarkan id_layanan
    ];

    // Relasi dengan Layanan
    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_trainer', 'id_layanan');
    }
}
