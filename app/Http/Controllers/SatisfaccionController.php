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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:satisfaccion,email',
            'nota' => 'required|integer|in:1,2,3,4,5',
            'obs' => 'nullable|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 500);
        }

        $satisfaccion = Satisfaccion::create($request->all());

        return response()->json($satisfaccion);
    }
}
