<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sefer;
use Illuminate\Http\Request;


class SeferController extends Controller
{
    // List all sefarim
    public function index()
    {
        return Sefer::with('publisher')->get();
    }

    // Create a new sefer
    public function store(Request $request)
    {
        $validated = $request->validate([
            'english_name' => 'required|string|max:255',
            'hebrew_name' => 'nullable|string|max:255',
            'name_languages' => 'nullable|array',
            'publisher_id' => 'nullable|exists:publishers,id',
            'edition' => 'nullable|integer',
            'publication_year' => 'nullable|integer',
        ]);

        $sefer = Sefer::create($validated);

        return response()->json($sefer, 201);
    }

    // View a single sefer
    public function show($id)
    {
        $sefer = Sefer::with('publisher')->findOrFail($id);
        return $sefer;
    }

    // Update a sefer
    public function update(Request $request, $id)
    {
        $sefer = Sefer::findOrFail($id);

        $validated = $request->validate([
            'english_name' => 'sometimes|required|string|max:255',
            'hebrew_name' => 'nullable|string|max:255',
            'name_languages' => 'nullable|array',
            'publisher_id' => 'nullable|exists:publishers,id',
            'edition' => 'nullable|integer',
            'publication_year' => 'nullable|integer',
        ]);

        $sefer->update($validated);

        return response()->json($sefer);
    }

    // Delete a sefer
    public function destroy($id)
    {
        $sefer = Sefer::findOrFail($id);
        $sefer->delete();

        return response()->json(['message' => 'Sefer deleted successfully']);
    }
}
