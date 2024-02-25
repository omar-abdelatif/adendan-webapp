<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsVideos extends Model
{
    use HasFactory;
    protected $table = 'news_videos';
    protected $fillable = [
        'url',
        'news_id'
    ];
    public function news() {
        return $this->belongsTo(News::class);
    }
}
