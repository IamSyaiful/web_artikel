<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MovieSubmission extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_REJECTED = 'rejected';

    public const STATUS_APPROVED = 'approved';

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'poster',
        'release_date',
        'duration',
        'director',
        'rating',
        'synopsis',
        'review',
        'status',
        'rejection_reason',
        'reviewed_by',
        'reviewed_at',
        'approved_movie_id',
    ];

    protected $casts = [
        'release_date' => 'date',
        'reviewed_at' => 'datetime',
        'rating' => 'decimal:1',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function approvedMovie(): BelongsTo
    {
        return $this->belongsTo(Movie::class, 'approved_movie_id');
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'movie_submission_genre');
    }
}
