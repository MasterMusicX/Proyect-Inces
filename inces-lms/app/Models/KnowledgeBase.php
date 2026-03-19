<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeBase extends Model
{
    protected $fillable = ['category', 'question', 'answer', 'tags', 'is_active', 'views'];
    protected function casts(): array {
        return ['tags' => 'array', 'is_active' => 'boolean'];
    }
}
