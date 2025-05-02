<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    //
    public function index()
    {
        return view('address');
    }
    public function store(Request $request)
    {
        // Logic to store address
        return response()->json(['message' => 'success']);
    }
    public function update(Request $request)
    {
        // Logic to update address
        return response()->json(['message' => 'success']);
    }
}
