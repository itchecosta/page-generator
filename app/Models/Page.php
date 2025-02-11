<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'published_at',
        'meta_description',
        'meta_keywords',
        'substitution_data',
        'page_set_id'
    ];

    // Define o relacionamento: uma Page pertence a um PageSet
    public function pageSet()
    {
        return $this->belongsTo(PageSet::class, 'page_set_id');
    }
}
