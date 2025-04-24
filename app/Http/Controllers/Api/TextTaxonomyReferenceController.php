<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TextTaxonomyReference;
use Illuminate\Http\Request;

class TextTaxonomyReferenceController extends Controller
{
    public function index()
    {
        return TextTaxonomyReference::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'text_id' => 'required|exists:texts,id',
            'taxonomy_id' => 'required|exists:taxonomy,id',
            'text_value' => 'required|string',
            'value' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        $record = TextTaxonomyReference::create($validated);
        return response()->json($record, 201);
    }

    public function destroy($id)
    {
        $record = TextTaxonomyReference::findOrFail($id);
        $record->delete();

        return response()->json(['message' => 'TextTaxonomyReference deleted']);
    }
}
