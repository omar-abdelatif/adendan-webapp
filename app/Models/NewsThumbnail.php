<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsThumbnail extends Model
{
    use HasFactory;
    protected $table = 'news_thumbnails';
    protected $fillable = [
        'thumbnail',
        'news_id'
    ];
    public function news() {
        return $this->belongsTo(News::class);
    }
}
