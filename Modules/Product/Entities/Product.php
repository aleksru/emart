<?php

namespace Modules\Product\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\Category;
use Modules\Media\Models\Traits\HasMedia;
use Modules\Seo\Models\Traits\HasSeo;
use Illuminate\Database\Eloquent\Builder;

class Product extends BaseModel
{
    use HasMedia, HasSeo;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'bool',
    ];

    /**
     * Описание медиа элементов.
     * @see HasMedia
     *
     * @var array
     */
    protected $media = [
        'image' => [
            'type' => 'image',
            'sizes' => [
                'small' => [120, 120],
                'medium' => [300, 300]
            ]
        ],
    ];

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @param Builder $query
     */
    public function scopeActive(Builder $query)
    {
        $query->where('is_active', 1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
