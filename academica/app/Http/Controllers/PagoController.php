<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        return Pago::all();
    }

    public function store(Request $request)
    {
        try {
            $pago = Pago::create($request->all());
            return response()->json(['msg' => 'ok', 'data' => $pago]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()]);
        }
    }

    public function update(Request $request)
    {
        try {
            $pago = Pago::findOrFail($request->id_pago);
            $pago->update($request->all());
            return response()->json(['msg' => 'ok', 'data' => $pago]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            // The request might have id_pago in the payload instead of URL
            $pago = Pago::findOrFail($request->id_pago);
            $pago->delete();
            return response()->json(['msg' => 'ok']);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()]);
        }
    }
}
