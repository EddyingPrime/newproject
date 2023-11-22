<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread; // Assuming your model is named Thread

class ForumController extends Controller
{
    /**
     * Get all threads.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $threads = Thread::all();

        return response()->json(['threads' => $threads], 200);
    }

    /**
     * Display a specific thread.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $thread = Thread::find($id);

        if (!$thread) {
            return response()->json(['error' => 'Thread not found'], 404);
        }

        return response()->json(['thread' => $thread], 200);
    }

    /**
     * Create a new thread.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $thread = Thread::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            // Add any additional fields as needed
        ]);

        return response()->json(['thread' => $thread], 201);
    }

    /**
     * Update a specific thread.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $thread = Thread::find($id);

        if (!$thread) {
            return response()->json(['error' => 'Thread not found'], 404);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $thread->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            // Add any additional fields as needed
        ]);

        return response()->json(['thread' => $thread], 200);
    }

    /**
     * Delete a specific thread.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $thread = Thread::find($id);

        if (!$thread) {
            return response()->json(['error' => 'Thread not found'], 404);
        }

        $thread->delete();

        return response()->json(['message' => 'Thread deleted successfully'], 200);
    }
}
