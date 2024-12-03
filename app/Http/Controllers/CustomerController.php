<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;

class CustomerController extends Controller
{
    public function register(Request $request)
    {
        // Validation
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8',
            'jenis_kelamin' => 'required|string|max:255',
            'tinggi_badan' => 'required|integer',
            'berat_badan' => 'required|integer',
        ]);

        // Creating the customer
        $customer = Customer::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'jenis_kelamin' => $request->jenis_kelamin,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
        ]);

        // Returning a response
        return response()->json([
            'customer' => $customer,
            'message' => 'Customer registered successfully!',
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $customer->createToken('Personal Access Token')->plainTextToken;

        return response()->json([
            'detail' => $customer,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out successfully']);
        }
        return response()->json(['message' => 'Not logged in'], 401);
    }

    public function index()
    {
        $allCustomers = Customer::all();
        return response()->json($allCustomers);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->update($request->all());
        return response()->json($customer);
    }

    public function destroy($id)
    {
        Customer::destroy($id);
        return response()->json(['message' => 'Customer deleted successfully']);
    }
}
