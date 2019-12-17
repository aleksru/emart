<?php

namespace App\Models;

use App\Models\Traits\HasBootEvents;
use App\Models\Traits\HasDynamicRelations;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель Eloquent с дополнительным функционалом.
 * 
 * @package App\Models
 */
class BaseModel extends Model
{
    use HasBootEvents;
    use HasDynamicRelations;
}