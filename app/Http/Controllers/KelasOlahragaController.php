<?php

namespace App\Http\Controllers;

use App\Models\Kelas_olahraga;
use App\Models\Layanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KelasOlahragaController extends Controller
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

        // Buat kelas olahraga berdasarkan layanan
        $kelasOlahraga = Kelas_olahraga::create([
            'id_layanan' => $layanan->id_layanan, // id_layanan dari layanan yang ada
            'jadwal_kelas' => $request->jadwal_kelas,
            'kuota_kelas' => $request->kuota_kelas,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Kelas Olahraga created successfully',
            'data' => $kelasOlahraga
        ], 201);
    }
}