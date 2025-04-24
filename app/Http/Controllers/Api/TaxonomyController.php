<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Taxonomy;
use Illuminate\Http\Request;

class TaxonomyController extends Controller
{
    public function index()
    {
        return Taxonomy::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug'           => 'required|string|max:255|unique:taxonomy,slug',
            'name_en'        => 'required|string|max:255',
            'name_he'        => 'nullable|string|max:255',
            'name_languages' => 'nullable|json',
            'note'           => 'nullable|string',
        ]);

        $taxonomy = Taxonomy::create($validated);
        return response()->json($taxonomy, 201);
    }

    public function show($id)
    {
        $taxonomy = Taxonomy::findOrFail($id);
        return response()->json($taxonomy);
    }

    public function update(Request $request, $id)
    {
        $taxonomy = Taxonomy::findOrFail($id);

        $validated = $request->validate([
            'slug'           => 'sometimes|string|max:255|unique:taxonomy,slug,' . $taxonomy->id,
            'name_en'        => 'sometimes|string|max:255',
            'name_he'        => 'nullable|string|max:255',
            'name_languages' => 'nullable|json',
            'note'           => 'nullable|string',
        ]);

        $taxonomy->update($validated);
        return response()->json($taxonomy);
    }

    public function destroy($id)
    {
        $taxonomy = Taxonomy::findOrFail($id);
        $taxonomy->delete();

        return response()->json(['message' => 'Taxonomy deleted']);
    }
}
