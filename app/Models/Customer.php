<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasApiTokens, HasFactory;

    public $timestamps = false; // Disable timestamps if not needed
    protected $table = 'customers'; // Refer to the table `customers`
    protected $primaryKey = 'id_customer'; // Primary key

    protected $fillable = [
        'username',
        'email',
        'password',
        'jenis_kelamin',
        'tinggi_badan',
        'berat_badan',
        'umur', // Include the `umur` field as it's in the table
    ];

    // Relationship with Pesanan (One-to-Many)
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_customer', 'id_customer');
    }
}