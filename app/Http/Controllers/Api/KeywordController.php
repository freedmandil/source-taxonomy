<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Keyword;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    public function index()
    {
        return Keyword::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_he' => 'required|string',
            'name_en' => 'nullable|string',
            'name_languages' => 'nullable|json',
            'note' => 'nullable|string',
        ]);

        return Keyword::create($data);
    }

    public function show(Keyword $keyword)
    {
        return $keyword;
    }

    public function update(Request $request, Keyword $keyword)
    {
        $data = $request->validate([
            'name_he' => 'sometimes|string',
            'name_en' => 'sometimes|string',
            'name_languages' => 'nullable|json',
            'note' => 'nullable|string',
        ]);

        $keyword->update($data);

        return $keyword;
    }

    public function destroy(Keyword $keyword)
    {
        $keyword->delete();

        return response()->noContent();
    }
}
