<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OcrData;
use Illuminate\Http\Request;

class OcrController extends Controller {
    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'nid' => 'required|string|unique:ocr_data,nid',
            'birth_date' => 'required|string',
            'mobile' => 'nullable|string|max:20',
        ]);
        OcrData::create($validatedData);
        return response()->json([
            'message' => 'OCR data stored successfully',
        ], 201);
    }
}
