<?php

namespace Modules\Category\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Media\Models\Traits\HasMedia;
use Modules\Seo\Models\Traits\HasSeo;

class Category extends BaseModel
{
    use HasMedia, HasSeo, NodeTrait, SoftDeletes;
    /**
     * Описание медиа элементов.
     * @see HasMedia
     *
     * @var array
     */
    protected $media = [
        'image' => [
            'type' => 'image',
            'single' => true,
            'sizes' => [
                'small' => [120, 120],
                'medium' => [300, 300]
            ]
        ],
    ];

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'bool'
    ];

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
//    public function parent()
//    {
//        return $this->belongsTo(Category::class);
//    }

//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\HasMany
//     */
//    public function subCategories()
//    {
//        return $this->hasMany(Category::class, 'parent_id', 'id');
//    }

    /**
     * @param Builder $query
     */
    public function scopeActive(Builder $query)
    {
        $query->where('is_active', 1);
    }
}
