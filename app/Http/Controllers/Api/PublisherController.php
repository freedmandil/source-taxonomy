<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index()
    {
        return Publisher::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_hebrew' => 'nullable|string|max:255',
            'name_languages' => 'nullable|json',
            'meta' => 'nullable|json',
        ]);

        return Publisher::create($validated);
    }

    public function show(Publisher $publisher)
    {
        return $publisher;
    }

    public function update(Request $request, Publisher $publisher)
    {
        $validated = $request->validate([
            'name_english' => 'sometimes|required|string|max:255',
            'name_hebrew' => 'nullable|string|max:255',
            'name_languages' => 'nullable|json',
            'meta' => 'nullable|json',
        ]);

        $publisher->update($validated);
        return $publisher;
    }

    public function destroy(Publisher $publisher)
    {
        $publisher->delete();
        return response()->noContent();
    }

    /**
     * Search for publishers by name in English, Hebrew, or other languages.
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        return Publisher::where('name_english', 'LIKE', "%{$query}%")
            ->orWhere('name_hebrew', 'LIKE', "%{$query}%")
            ->orWhereJsonContains('name_languages', $query)
            ->get();
    }

}
