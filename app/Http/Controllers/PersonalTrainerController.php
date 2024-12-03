<?php

namespace App\Http\Controllers;

use App\Models\Personal_trainer;
use App\Models\Layanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class PersonalTrainerController extends Controller
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

        // Buat personal trainer berdasarkan layanan
        $personalTrainer = Personal_trainer::create([
            'id_layanan' => $layanan->id_layanan,  // id_layanan dari layanan yang ada
            'rating_trainer' => $request->rating_trainer,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Personal Trainer created successfully',
            'data' => $personalTrainer
        ], 201);
    }
}
