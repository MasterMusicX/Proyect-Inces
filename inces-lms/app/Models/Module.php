<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['course_id', 'title', 'description', 'order', 'is_published'];

    protected function casts(): array {
        return ['is_published' => 'boolean'];
    }

    public function course()    { return $this->belongsTo(Course::class); }
    public function resources() { return $this->hasMany(Resource::class)->orderBy('order'); }
}
