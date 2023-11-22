<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Board Game</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .error-message {
            color: red;
            margin-top: 8px;
        }

        .success-message {
            color: green;
            margin-top: 8px;
        }
    </style>
</head>
<body>

<div>
    <h1>Add New Board Game</h1>

    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="error-message">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('boardgames.add') }}" enctype="multipart/form-data">
        @csrf

        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ old('name') }}" required>

        <label for="description">Description:</label>
        <textarea name="description" required>{{ old('description') }}</textarea>

        <label for="image">Image:</label>
        <input type="file" name="image" accept="image/*" required>

        <label for="min_players">Min Players:</label>
        <input type="number" name="min_players" value="{{ old('min_players') }}" required>

        <label for="max_players">Max Players:</label>
        <input type="number" name="max_players" value="{{ old('max_players') }}" required>

        <label for="min_playtime">Min Playtime (minutes):</label>
        <input type="number" name="min_playtime" value="{{ old('min_playtime') }}" required>

        <label for="max_playtime">Max Playtime (minutes):</label>
        <input type="number" name="max_playtime" value="{{ old('max_playtime') }}" required>

        <label for="year_published">Year Published:</label>
        <input type="number" name="year_published" value="{{ old('year_published') }}" required>

        <label for="designer">Designer:</label>
        <input type="text" name="designer" value="{{ old('designer') }}" required>

        <label for="publisher">Publisher:</label>
        <input type="text" name="publisher" value="{{ old('publisher') }}" required>

        <label for="categories">Categories:</label>
        <select name="categories[]" multiple required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <label for="mechanics">Mechanics:</label>
        <select name="mechanics[]" multiple required>
            @foreach
