<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsComments extends Model {
    protected $fillable = [
        'author',
        'content',
        'news_id',
    ];
    public function news() {
        return $this->belongsTo(News::class, 'news_id');
    }
}
