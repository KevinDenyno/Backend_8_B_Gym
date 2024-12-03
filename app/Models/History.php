<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class History extends Model
{
    use HasFactory;

    public $timestamps = false; // Disable timestamps if not needed
    protected $table = 'history'; // Refer to the table `history`
    protected $primaryKey = 'id_history'; // Primary key

    protected $fillable = [
        'id_pesanan',
        'deskripsi_history',
    ];

    // Relationship with Pesanan (Belongs-To)
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }
}
