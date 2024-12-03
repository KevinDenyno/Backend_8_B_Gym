<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesanan extends Model
{
    use HasFactory;

    public $timestamps = false; // Disable timestamps if not needed
    protected $table = 'pesanans'; // Refer to the table `pesanans`
    protected $primaryKey = 'id_pesanan'; // Primary key

    protected $fillable = [
        'id_customer',
        'tanggal_pesanan',
        'detail',
    ];

    // Relationship with Customer (Belongs-To)
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }

    // Relationship with History (One-to-One)
    public function history()
    {
        return $this->hasOne(History::class, 'id_pesanan', 'id_pesanan');
    }
}