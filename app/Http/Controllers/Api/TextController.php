<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Text;
use Illuminate\Http\Request;

class TextController extends Controller
{
    public function index()
    {
        return Text::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sefer_id'     => 'required|exists:sefarim,id',
            'text'         => 'required|string',
            'note'         => 'nullable|string',
        ]);

        $text = Text::create($validated);
        return response()->json($text, 201);
    }

    public function show($id)
    {
        $text = Text::findOrFail($id);
        return response()->json($text);
    }

    public function update(Request $request, $id)
    {
        $text = Text::findOrFail($id);

        $validated = $request->validate([
            'sefer_id'     => 'sometimes|exists:sefarim,id',
            'text'         => 'sometimes|string',
            'note'         => 'nullable|string',
        ]);

        $text->update($validated);
        return response()->json($text);
    }

    public function destroy($id)
    {
        $text = Text::findOrFail($id);
        $text->delete();

        return response()->json(['message' => 'Text deleted']);
    }
}
