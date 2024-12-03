<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas_olahraga extends Model
{
    use HasFactory;

    protected $table = 'kelas_olahraga';
    protected $primaryKey = 'id';
    public $timestamps = false; 
    protected $fillable = [
        'id',
        'jadwal_kelas',
        'kuota_kelas',
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id', 'id_layanan');
    }
}
