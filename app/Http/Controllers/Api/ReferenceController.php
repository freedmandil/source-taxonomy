<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TextReference;

use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    public function index()
    {
        return TextReference::with(['textSection', 'taxonomy'])->get();
    }

    public function store(Request $request)
    {
            $validated = $request->validate([
                'text_section_id' => 'required|integer|exists:texts,id',
                'taxonomy_id'     => 'required|integer|exists:taxonomy,id',
                'text_value'      => 'nullable|string|max:255',
                'numeric_value'    => 'nullable|integer',
                'note'            => 'nullable|string',
            ]);

        $reference = TextReference::create($validated);
        return response()->json($reference, 201);
    }

    public function show($id)
    {
        $reference = TextReference::with(['textSection', 'taxonomy'])->findOrFail($id);
        return response()->json($reference);
    }

    public function update(Request $request, $id)
    {
        $reference = TextReference::findOrFail($id);

        $validated = $request->validate([
            'text_section_id' => 'sometimes|integer|exists:texts,id',
            'taxonomy_id'     => 'sometimes|integer|exists:taxonomy,id',
            'text_value'      => 'nullable|string|max:255',
            'numeric_value'       => 'nullable|integer',
            'note'            => 'nullable|string',
        ]);

        $reference->update($validated);
        return response()->json($reference);
    }

    public function destroy($id)
    {
        $reference = TextReference::findOrFail($id);
        $reference->delete();

        return response()->json(['message' => 'Reference deleted']);
    }
}
