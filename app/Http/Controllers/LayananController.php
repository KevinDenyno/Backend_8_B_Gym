<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Alat_gym;
use App\Models\Kelas_olahraga;
use App\Models\Personal_trainer;
use Illuminate\Http\Request;
use Exception;

class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Layanan::all();
            return response()->json([
                "status" => true,
                "message" => "Get successful",
                "data" => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Something went wrong",
                "data" => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'nama_layanan' => 'required|string|max:255',
        'tipe_layanan' => 'required|in:Kelas,Alat Gym,Trainer',
        'deskripsi_layanan' => 'nullable|string|max:255',
        'harga' => 'required|numeric',
        // Validasi tambahan untuk properti spesifik tipe layanan
        'status_ketersediaan' => 'required_if:tipe_layanan,Alat Gym|boolean',
        'jadwal_kelas' => 'required_if:tipe_layanan,Kelas|string',
        'kuota_kelas' => 'required_if:tipe_layanan,Kelas|integer',
        'rating_trainer' => 'required_if:tipe_layanan,Trainer|integer',
    ]);

    try {
        // Buat data layanan
        $layanan = Layanan::create($request->only(['nama_layanan', 'tipe_layanan', 'deskripsi_layanan', 'harga']));

        // Handle pembuatan data anak berdasarkan tipe layanan
        $layananWithRelation = null;
        switch ($validated['tipe_layanan']) {
            case 'Alat Gym':
                Alat_gym::create([
                    'id' => $layanan->id_layanan,
                    'status_ketersediaan' => $request->status_ketersediaan,
                ]);
                $layananWithRelation = Layanan::with('alatGym')->find($layanan->id_layanan);
                break;

            case 'Kelas':
                Kelas_olahraga::create([
                    'id' => $layanan->id_layanan,
                    'jadwal_kelas' => $request->jadwal_kelas,
                    'kuota_kelas' => $request->kuota_kelas,
                ]);
                $layananWithRelation = Layanan::with('kelasOlahraga')->find($layanan->id_layanan);
                break;

            case 'Trainer':
                Personal_trainer::create([
                    'id' => $layanan->id_layanan,
                    'rating_trainer' => $request->rating_trainer,
                ]);
                $layananWithRelation = Layanan::with('personalTrainer')->find($layanan->id_layanan);
                break;
        }

        return response()->json([
            "status" => true,
            "message" => "Create successful",
            "data" => $layananWithRelation,
        ], 200);
    } catch (Exception $e) {
        return response()->json([
            "status" => false,
            "message" => "Something went wrong",
            "data" => $e->getMessage(),
        ], 400);
    }
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'tipe_layanan' => 'required|in:Kelas,Alat Gym,Trainer',
            'deskripsi_layanan' => 'nullable|string|max:255',
            'harga' => 'required|numeric',
            // Validasi tambahan untuk properti spesifik tipe layanan
            'status_ketersediaan' => 'required_if:tipe_layanan,Alat Gym|boolean',
            'jadwal_kelas' => 'required_if:tipe_layanan,Kelas|string',
            'kuota_kelas' => 'required_if:tipe_layanan,Kelas|integer',
            'rating_trainer' => 'required_if:tipe_layanan,Trainer|integer',
        ]);

        try {
            $layanan = Layanan::findOrFail($id);
            $layanan->update($request->only(['nama_layanan', 'tipe_layanan', 'deskripsi_layanan', 'harga']));

            // Update child model based on 'tipe_layanan'
            switch ($validated['tipe_layanan']) {
                case 'Alat Gym':
                    $alatGym = Alat_gym::where('id', $layanan->id_layanan)->first();
                    if ($alatGym) {
                        $alatGym->update(['status_ketersediaan' => $request->status_ketersediaan]);
                    }
                    break;
                case 'Kelas':
                    $kelasOlahraga = Kelas_olahraga::where('id', $layanan->id_layanan)->first();
                    if ($kelasOlahraga) {
                        $kelasOlahraga->update([
                            'jadwal_kelas' => $request->jadwal_kelas,
                            'kuota_kelas' => $request->kuota_kelas,
                        ]);
                    }
                    break;
                case 'Trainer':
                    $trainer = Personal_trainer::where('id', $layanan->id_layanan)->first();
                    if ($trainer) {
                        $trainer->update(['rating_trainer' => $request->rating_trainer]);
                    }
                    break;
            }

            return response()->json([
                "status" => true,
                "message" => "Update successful",
                "data" => $layanan
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Something went wrong",
                "data" => $e->getMessage()
            ], 400);
        }
    }

    public function getByType($tipe_layanan)
    {
        try {
            // Validasi tipe layanan
            if (!in_array($tipe_layanan, ['Kelas', 'Alat Gym', 'Trainer'])) {
                return response()->json([
                    "status" => false,
                    "message" => "Invalid layanan type. Allowed types are: Kelas, Alat Gym, Trainer.",
                ], 400);
            }

            // Filter layanan berdasarkan tipe
            $data = Layanan::where('tipe_layanan', $tipe_layanan)->with([
                'alatGym', 'kelasOlahraga', 'personalTrainer'
            ])->get();

            return response()->json([
                "status" => true,
                "message" => "Get layanan by type successful",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Something went wrong",
                "data" => $e->getMessage()
            ], 400);
        }
    }

    /**
 * Remove the specified resource from storage.
 */
            public function destroy($id)
            {
                try {
                    // Temukan layanan berdasarkan ID
                    $layanan = Layanan::findOrFail($id);

                    // Hapus data terkait berdasarkan tipe layanan
                    switch ($layanan->tipe_layanan) {
                        case 'Alat Gym':
                            $alatGym = Alat_gym::where('id', $layanan->id_layanan)->first();
                            if ($alatGym) {
                                $alatGym->delete();
                            }
                            break;
                        case 'Kelas':
                            $kelasOlahraga = Kelas_olahraga::where('id', $layanan->id_layanan)->first();
                            if ($kelasOlahraga) {
                                $kelasOlahraga->delete();
                            }
                            break;
                        case 'Trainer':
                            $trainer = Personal_trainer::where('id', $layanan->id_layanan)->first();
                            if ($trainer) {
                                $trainer->delete();
                            }
                            break;
                    }

                    // Hapus layanan setelah anak dihapus
                    $layanan->delete();

                    return response()->json([
                        "status" => true,
                        "message" => "Delete successful",
                        "data" => $layanan
                    ], 200);

                } catch (Exception $e) {
                    return response()->json([
                        "status" => false,
                        "message" => "Something went wrong",
                        "data" => $e->getMessage()
                    ], 400);
                }
            }

}

