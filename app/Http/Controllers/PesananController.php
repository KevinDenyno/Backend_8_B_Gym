<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Pesanan::all();
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
        try {
            $data = Pesanan::create($request->all());
            return response()->json([
                "status" => true,
                "message" => "Create successful",
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
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data = Pesanan::find($id);
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Pesanan::find($id);
            $data->update($request->all());
            return response()->json([
                "status" => true,
                "message" => "Update successful",
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
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Pesanan::find($id);
            $data->delete();
            return response()->json([
                "status" => true,
                "message" => "Delete successful",
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
}
