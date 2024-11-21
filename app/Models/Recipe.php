<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id','recipe_image', 'ingredients', 'preparation'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    public function comments()
    {
        return $this->belongsToMany(User::class, 'comments')
        ->withPivot('body');
    }

    public function scopeSearch(Builder $query , $value)
    {
        $value =str_replace(' ', '', $value);
        $query->whereRaw("REPLACE(name, ' ', '') LIKE ?", "%$value%");
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

}
