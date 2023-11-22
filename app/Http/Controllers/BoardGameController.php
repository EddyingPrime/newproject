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

    public function create()
    {
        return view('boardgamesadd');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), $this->validationRules());
    
        if ($validator->fails()) {
            return redirect()->route('boardgames.add')->withErrors($validator)->withInput();
        }
    
        // Create a unique filename for the uploaded file
        $filename = time() . '_' . $request->file('image')->getClientOriginalName();
    
        // Move the uploaded file to the destination directory
        $request->file('image')->move(public_path('/uploads'), $filename);
    
        // Now you can use $filename to store the file name in your database or perform other actions
    
        $boardGame = BoardGame::create($request->all());
        $boardGame->image = $filename; // Store the filename in the database
        $boardGame->save();
    
        // Redirect back to the form view with a success message
        return redirect()->route('boardgames.add')->with('success', 'Board game added successfully');
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
    
        $validator = Validator::make($request->all(), $this->validationRules());
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $boardGame->update($request->all());
        $this->handleImage($request, $boardGame);
    
        // Respond with JSON data after successful update
        return response()->json(['data' => $boardGame], 200);
    }
    // Remove the specified resource from storage.
    public function destroy($id)
    {
        BoardGame::findOrFail($id)->delete();
        return response()->json(['message' => 'Board game deleted successfully'], 204);
    }

    private function validationRules()
    {
        return [
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
        ];
    }

    private function handleImage(Request $request, BoardGame $boardGame)
    {
        if ($request->hasFile('image')) {
            $boardGame->image = $request->file('image')->store('board-games');
        }
    }
}

