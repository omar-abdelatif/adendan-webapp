<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $table = 'news';
    protected $fillable = [
        'title',
        'description',
        'slug',
        'category',
        'img',
        'shortlink',
        'thumbnail'
    ];
    public function thumbnails()
    {
        return $this->hasMany(NewsThumbnail::class);
    }
    public function videos(){
        return $this->hasMany(NewsVideos::class);
    }
}
