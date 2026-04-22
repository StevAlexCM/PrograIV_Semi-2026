<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index()
    {
        return Reporte::all();
    }

    public function store(Request $request)
    {
        try {
            $reporte = Reporte::create($request->all());
            return response()->json(['msg' => 'ok', 'data' => $reporte]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()]);
        }
    }

    public function update(Request $request)
    {
        try {
            $reporte = Reporte::findOrFail($request->id_reporte);
            $reporte->update($request->all());
            return response()->json(['msg' => 'ok', 'data' => $reporte]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $reporte = Reporte::findOrFail($request->id_reporte);
            $reporte->delete();
            return response()->json(['msg' => 'ok']);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()]);
        }
    }
}
