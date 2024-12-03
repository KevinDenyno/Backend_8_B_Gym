<?php

namespace App\Http\Controllers;

use App\Models\Alat_gym;
use App\Models\Layanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AlatGymController extends Controller
{
    public function store(Request $request)
    {
        // Ambil ID layanan yang dipilih
        $layanan = Layanan::find($request->id_layanan);

        // Cek apakah layanan ada
        if (!$layanan) {
            return response()->json([
                'status' => false,
                'message' => 'Layanan not found'
            ], 404);
        }

        // Buat alat gym berdasarkan layanan
        $alatGym = Alat_gym::create([
            'id_layanan' => $layanan->id_layanan, // id_layanan dari layanan yang ada
            'status_ketersediaan' => $request->status_ketersediaan,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Alat Gym created successfully',
            'data' => $alatGym
        ], 201);
    }
}