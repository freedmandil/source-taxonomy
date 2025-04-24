<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TagText;
use Illuminate\Http\Request;

class TagTextController extends Controller
{
    public function index()
    {
        return TagText::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'text_id' => 'required|exists:texts,id',
            'tag_id' => 'required|exists:tags,id',
            'note' => 'nullable|string',
        ]);

        $record = TagText::create($validated);
        return response()->json($record, 201);
    }

    public function destroy($id)
    {
        $record = TagText::findOrFail($id);
        $record->delete();

        return response()->json(['message' => 'TagText deleted']);
    }
}
