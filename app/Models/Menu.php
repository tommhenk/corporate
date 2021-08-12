<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'path', 'parent_id'];

    public function delete($options = []) {
        $child = self::where('parent_id', $this->id);
        $child->delete();
        return parent::delete($options);
    }
}
