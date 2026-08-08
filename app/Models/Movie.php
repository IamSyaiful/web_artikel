<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'poster',
        'release_date',
        'duration',
        'director',
        'rating',
        'synopsis',
        'review',
    ];

    protected $casts = [
        'release_date' => 'date',
        'rating' => 'decimal:1',
    ];

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'movie_genre');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
}
