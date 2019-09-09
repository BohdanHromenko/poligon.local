<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BlogCategory
 *
 * @package App\Models
 *
 * @property string                 $title
 * @property string                 $slug
 * @property-read BlogCategory      $parentCategory
 * @property-read string            $parentTitle
 */
class BlogCategory extends Model
{
    use SoftDeletes;

    /**
     * Root ID
     */
    const ROOT = 1;

    protected $fillable
        = [
            'title',
            'slug',
            'parent_id',
            'description',
        ];

    /**
     * Get parent category.
     *
     * @return BlogCategory
     */
    public function parentCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'parent_id', 'id');
    }

    /**
     * Accessory Example (Accessor)
     *
     * https://laravel.com/docs/5.8/eloquent-mutators#accessors-and-mutators
     *
     * @return string
     */
    public function getParentTitleAttribute()
    {
        $title = $this->parentCategory->title
            ?? ($this->isRoot()
                ? 'Root'
                : '???');

        return$title;
    }

    /**
     * Is the current object root.
     *
     * @return bool
     */
    public function isRoot()
    {
        return $this->id === BlogCategory::ROOT;
    }
}
