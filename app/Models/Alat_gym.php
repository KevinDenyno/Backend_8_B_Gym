<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alat_gym extends Model
{
    use HasFactory;

    protected $table = 'alat_gym';
    protected $primaryKey = 'id';
    public $timestamps = false; 
    

    protected $fillable = [
        'id',
        'status_ketersediaan',
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id', 'id_layanan');
    }

    // Check if the gym equipment is available
    public function isAvailable()
    {
        return $this->status_ketersediaan === 1; // Assuming 1 represents "tersedia"
    }
}
