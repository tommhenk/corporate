<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'alias', 'filter_id', 'text','meta_desc', 'keywords', 'img','customer'
    ];

    public function filter (){
        return $this->belongsTo(Filter::class);
    }
}
