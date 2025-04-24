<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KeywordText;
use Illuminate\Http\Request;

class KeywordTextController extends Controller
{
    public function index()
    {
        return KeywordText::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'text_id' => 'required|exists:texts,id',
            'keyword_id' => 'required|exists:keywords,id',
            'note' => 'nullable|string',
        ]);

        $record = KeywordText::create($validated);
        return response()->json($record, 201);
    }

    public function destroy($id)
    {
        $record = KeywordText::findOrFail($id);
        $record->delete();

        return response()->json(['message' => 'KeywordText deleted']);
    }
}
