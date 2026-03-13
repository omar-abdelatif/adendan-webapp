<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OcrData;
use Illuminate\Http\Request;

class OcrController extends Controller {
    public function store(Request $request) {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'nid' => 'required|numeric|digits:14|unique:ocr_data,nid',
            'birth_date' => 'required|date',
            'mobile' => 'nullable|string|max:20',
        ]);

        // Store the validated data in the database
        $ocrData = OcrData::create($validatedData);

        // Return a response indicating success
        return response()->json([
            'message' => 'OCR data stored successfully',
            'data' => $ocrData,
        ], 201);
    }
}
