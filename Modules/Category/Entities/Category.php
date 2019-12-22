<?php

namespace Modules\Category\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Models\Traits\HasMedia;

class Category extends BaseModel
{
    use HasMedia;
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
    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
