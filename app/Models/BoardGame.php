<?php

// app/Models/BoardGame.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'min_players',
        'max_players',
        'min_playtime',
        'max_playtime',
        'year_published',
        'designer',
        'publisher',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function mechanics()
    {
        return $this->belongsToMany(Mechanic::class);
    }
}

