<?php

namespace App\Http\Controllers;

use App\Models\Satisfaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SatisfaccionController extends Controller
{
    public function index()
    {
        return Satisfaccion::all();
    }

    public function getGrafico()
    {
        $grafico = Satisfaccion::selectRaw('count(id) as cantidad, calificacion')->groupBy('calificacion')->get();

        $resultado = [
            ['name' => '1 (Pesima)', 'value' => 0],
            ['name' => '2 (Regular)', 'value' => 0],
            ['name' => '3 (Aceptable)', 'value' => 0],
            ['name' => '4 (Buena)', 'value' => 0],
            ['name' => '5 (Excelente)', 'value' => 0],
        ];
        foreach ($grafico as $valor) {
            $resultado[$valor->calificacion - 1]['value'] = $valor->cantidad;
        }

        return response()->json($resultado);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:satisfaccion,email',
            'calificacion' => 'required|integer|in:1,2,3,4,5',
            'obs' => 'nullable|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 500);
        }

        $request->merge(['fecha' => date('Y-m-d H:i:s')]);
        $satisfaccion = Satisfaccion::create($request->all());

        return response()->json($satisfaccion);
    }
}
