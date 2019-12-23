<?php

namespace Modules\Seo\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $table = 'seo';
    
    protected $guarded = ['id'];
    
    protected $casts = [
        'content' => 'array',
    ];
}
