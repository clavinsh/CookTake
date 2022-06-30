<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Recipe;
use App\Models\User;

class Tag extends Model
{
    use HasFactory;

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipe_tags');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'followed_tags');
    }
}
