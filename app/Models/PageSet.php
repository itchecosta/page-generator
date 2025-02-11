<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSet extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_template',
        'content_template',
        'published_at',
        'meta_description',
        'meta_keywords',
        'csv_file'
    ];

    public function pages()
    {
        return $this->hasMany(Page::class, 'page_set_id');
    }
}
