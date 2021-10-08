<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'text',
        'image',
        'published_at',
        'status'
    ];

    // Optional
    protected $appends = [
        'class_name',
        'image_base_path'
    ];

    const PAGINATION_LIMIT = 20;
    const RESPONSE_OK = 200;
    const RESPONSE_CREATED = 201;

    /**
     * Accessors
     */
    public function getClassNameAttribute()
    {
        return strtolower(class_basename($this));
    }

    public function getImageBasePathAttribute()
    {
        return "/uploads/{$this->class_name}";
    }
}
