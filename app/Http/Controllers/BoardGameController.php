<?php

namespace App\Http\Controllers;

use App\Models\BoardGame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BoardGameController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $boardGames = BoardGame::all();
        return response()->json(['data' => $boardGames]);
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required',
            'image' => 'required|image|max:2048',
            'min_players' => 'required|integer',
            'max_players' => 'required|integer',
            'min_playtime' => 'required|integer',
            'max_playtime' => 'required|integer',
            'year_published' => 'required|integer',
            'designer' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $boardGame = new BoardGame($request->all());
        $boardGame->image = $request->file('image')->store('board-games');
        $boardGame->save();

        return response()->json(['data' => $boardGame], 201);
    }

    // Display the specified resource.
    public function show($id)
    {
        $boardGame = BoardGame::findOrFail($id);
        return response()->json(['data' => $boardGame]);
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $boardGame = BoardGame::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
            'min_players' => 'required|integer',
            'max_players' => 'required|integer',
            'min_playtime' => 'required|integer',
            'max_playtime' => 'required|integer',
            'year_published' => 'required|integer',
            'designer' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->hasFile('image')) {
            $boardGame->image = $request->file('image')->store('board-games');
        }

        $boardGame->update($request->all());

        return response()->json(['data' => $boardGame], 200);
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        BoardGame::findOrFail($id)->delete();
        return response()->json(['message' => 'Board game deleted successfully'], 204);
    }
}
