<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DB;
use Illuminate\Http\Request;

class SubTopicTopicController extends Controller
{
    public function index()
    {
        return DB::table('subtopic_topic')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'sub_topic_id' => 'required|exists:sub_topics,id',
            'note' => 'nullable|string',
        ]);

        DB::table('subtopic_topic')->insert($data);

        return response()->json(['message' => 'Linked successfully'], 201);
    }

    public function destroy(Request $request)
    {
        $data = $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'sub_topic_id' => 'required|exists:sub_topics,id',
        ]);

        DB::table('subtopic_topic')
            ->where('topic_id', $data['topic_id'])
            ->where('sub_topic_id', $data['sub_topic_id'])
            ->delete();

        return response()->noContent();
    }
}
