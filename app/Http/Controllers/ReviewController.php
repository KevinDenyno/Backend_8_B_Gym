<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Tampilkan semua review
    public function index()
    {
        $reviews = Review::with(['customer', 'layanan', 'kelasOlahraga'])->get();
        return response()->json($reviews);
    }

    // Tampilkan detail review berdasarkan ID
    public function show($id)
    {
        $review = Review::with(['customer', 'layanan', 'kelasOlahraga'])->find($id);
        if (!$review) {
            return response()->json(['message' => 'Review tidak ditemukan'], 404);
        }
        return response()->json($review);
    }

    // Tambah review baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_customer' => 'required|exists:customers,id_customer',
            'id_layanan' => 'nullable|exists:layanans,id_layanan',
            'id_kelas' => 'nullable|exists:kelas_olahraga,id_kelas',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        $review = Review::create($validated);
        return response()->json(['message' => 'Review berhasil ditambahkan', 'data' => $review], 201);
    }

    // Update review
    public function update(Request $request, $id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(['message' => 'Review tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'rating' => 'sometimes|integer|min:1|max:5',
            'komentar' => 'sometimes|string',
        ]);

        $review->update($validated);
        return response()->json(['message' => 'Review berhasil diperbarui', 'data' => $review]);
    }

    // Hapus review
    public function destroy($id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(['message' => 'Review tidak ditemukan'], 404);
        }

        $review->delete();
        return response()->json(['message' => 'Review berhasil dihapus']);
    }
}
