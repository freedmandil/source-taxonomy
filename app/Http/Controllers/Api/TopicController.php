<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index()
    {
        return Topic::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_he' => 'required|string',
            'name_en' => 'nullable|string',
            'name_languages' => 'nullable|json',
            'note' => 'nullable|string',
        ]);

        return Topic::create($data);
    }

    public function show(Topic $topic)
    {
        return $topic;
    }

    public function update(Request $request, Topic $topic)
    {
        $data = $request->validate([
            'name_he' => 'sometimes|string',
            'name_en' => 'sometimes|string',
            'name_languages' => 'nullable|json',
            'note' => 'nullable|string',
        ]);

        $topic->update($data);

        return $topic;
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();

        return response()->noContent();
    }
}
