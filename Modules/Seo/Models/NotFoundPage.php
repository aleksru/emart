<?php

namespace Modules\Seo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class NotFoundPage extends Model
{
    protected $table = 'seo_not_found_pages';
    
    protected $guarded = ['id'];
    
    protected $hidden = [
        'created_at', 'updated_at', 'id'
    ];
    
    protected $appends = [
        'date'
    ];

    /**
     * @return string
     */
    public function getDateAttribute() 
    {
        return $this->created_at->format('j F Y, H:i:s');
    }
    
    /**
     * Создает запись о ненайденной странице.
     * 
     * @param Request $request
     * @return mixed
     */
    public static function createFromRequest(Request $request) 
    {
        $data = [];
        $data['url'] = $request->url();
        $data['referer'] = $request->header('referer', $request->server('HTTP_REFERER'));
        $data['user_agent'] = $request->header('user_agent', $request->server('HTTP_USER_AGENT'));

        return static::create($data);
    }
}
