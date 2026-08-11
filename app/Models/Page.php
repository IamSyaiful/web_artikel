<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function contents(): HasMany
    {
        return $this->hasMany(PageContent::class);
    }
}
