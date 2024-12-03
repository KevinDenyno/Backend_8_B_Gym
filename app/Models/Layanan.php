<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';
    protected $primaryKey = 'id_layanan';
    public $timestamps = false; 

    protected $fillable = [
        'nama_layanan',
        'tipe_layanan',
        'deskripsi_layanan',
        'harga',
    ];

    public function alatGym()
    {
        return $this->hasMany(Alat_gym::class);
    }

    // Add relationships for other types if needed
    public function kelasOlahraga()
    {
        return $this->hasMany(Kelas_olahraga::class);
    }

    public function personalTrainer()
    {
        return $this->hasMany(Personal_trainer::class);
    }
}
