<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PageContent extends Model
{
    protected $fillable = [
        'page_id',
        'section',
        'key',
        'value',
        'type',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
