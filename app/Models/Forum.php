<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $fillable = ['title', 'content', 'upvotes', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}