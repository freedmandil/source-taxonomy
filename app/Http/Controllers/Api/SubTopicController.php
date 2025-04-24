<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubTopic;
use Illuminate\Http\Request;

class SubTopicController extends Controller
{
    public function index()
    {
        return SubTopic::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_he' => 'required|string',
            'name_en' => 'nullable|string',
            'name_languages' => 'nullable|json',
            'note' => 'nullable|string',
        ]);

        return SubTopic::create($data);
    }

    public function show(SubTopic $subTopic)
    {
        return $subTopic;
    }

    public function update(Request $request, SubTopic $subTopic)
    {
        $data = $request->validate([
            'name_he' => 'sometimes|string',
            'name_en' => 'sometimes|string',
            'name_languages' => 'nullable|json',
            'note' => 'nullable|string',
        ]);

        $subTopic->update($data);

        return $subTopic;
    }

    public function destroy(SubTopic $subTopic)
    {
        $subTopic->delete();

        return response()->noContent();
    }
}
