<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Personal_trainer extends Model
{
    use HasFactory;

    protected $table = 'personal_trainer'; 
    protected $primaryKey = 'id';
    public $timestamps = false; 

    protected $fillable = [
        'rating_trainer',
        'id',
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id', 'id_layanan');
    }
}
