<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Reference;
use App\Models\TextSection;
use App\Models\TextSectionReference;
use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    public function index()
    {
        return Reference::with(['textSection', 'taxonomy'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'text_section_id' => 'required|integer|exists:texts,id',
            'taxonomy_id'     => 'required|integer|exists:taxonomy,id',
            'reference_type'  => 'nullable|string|max:255',
            'text_value'      => 'nullable|string|max:255',
            'int_value'       => 'nullable|integer',
            'note'            => 'nullable|string',
        ]);

        $reference = Reference::create($validated);
        return response()->json($reference, 201);
    }

    public function show($id)
    {
        $reference = Reference::with(['textSection', 'taxonomy'])->findOrFail($id);
        return response()->json($reference);
    }

    public function update(Request $request, $id)
    {
        $reference = Reference::findOrFail($id);

        $validated = $request->validate([
            'text_section_id' => 'sometimes|integer|exists:texts,id',
            'taxonomy_id'     => 'sometimes|integer|exists:taxonomy,id',
            'reference_type'  => 'nullable|string|max:255',
            'text_value'      => 'nullable|string|max:255',
            'int_value'       => 'nullable|integer',
            'note'            => 'nullable|string',
        ]);

        $reference->update($validated);
        return response()->json($reference);
    }

    public function destroy($id)
    {
        $reference = Reference::findOrFail($id);
        $reference->delete();

        return response()->json(['message' => 'Reference deleted']);
    }
}
