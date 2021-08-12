<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'text', 'text', 'site', 'user_id', 'article_id', 'parent_id', 'email'
    ];

    public function article () {
        return $this->belongsTo(Article::class);
    }

    public function user () {
        return $this->belongsTo(User::class);
    }
}
