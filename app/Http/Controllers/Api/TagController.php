<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        return Tag::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'name_he' => 'nullable|string',
            'name_languages' => 'nullable|array',
        ]);

        $tag = Tag::create($validated);
        return response()->json($tag, 201);
    }

    public function show($id)
    {
        return Tag::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'name_he' => 'nullable|string',
            'name_languages' => 'nullable|array',
        ]);

        $tag->update($validated);
        return response()->json($tag);
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return response()->json(['message' => 'Tag deleted']);
    }
}
