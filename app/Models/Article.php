<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'text', 'desc', 'img','id','category_id', 'alias', 'keywords', 'meta_desc'
    ];

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function category () {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function comments () {
        return $this->hasMany(Comment::class);
    }
}
