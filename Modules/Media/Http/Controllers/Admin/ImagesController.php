<?php

namespace Modules\Media\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Media\Http\Requests\Admin\ImageRequest;
use Modules\Media\Models\Image;

class ImagesController extends Controller
{
    /**
     * Загружает изображение.
     * 
     * @param  ImageRequest $request
     * @return Response
     * @throws \Exception
     */
    public function upload(ImageRequest $request)
    {
        if ($request->hasFile('image')) {
            $model = $request->model;
            $type = $request->type;
            $element = $model::find($request->id);
            $image = Image::createFromImage($request->file('image'), $type);

            /**
             * Пробегаемся по свойству $media модели и вытаскиваем настройки.
             */
            $media = $element->getMedia();
            if (isset($media[$type]['sizes'])) {
                foreach ($media[$type]['sizes'] as $modifier => $size) {
                    $image->fit($size[0], $size[1],
                        is_string($modifier) && mb_strlen($modifier) > 0 ? $modifier : null);
                }
            }

            $element->imagesDynamicRelation($type)->save($image);
            
            return response()->json(['image_id' => $image->id]);
        }
    }

    /**
     * Заменяет изображение на новое.
     * 
     * @param ImageRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function replace(ImageRequest $request)
    {
        if ($request->hasFile('image')) {
            $model = $request->model;
            $type = $request->type;
            $element = $model::find($request->id);
            $image = Image::createFromImage($request->file('image'), $type);

            /**
             * Пробегаемся по свойству $media модели и вытаскиваем настройки.
             */
            $media = $element->getMedia();
            if (isset($media[$type]['sizes'])) {
                foreach ($media[$type]['sizes'] as $modifier => $size) {
                    $image->fit($size[0], $size[1],
                        is_string($modifier) && mb_strlen($modifier) > 0 ? $modifier : null);
                }
            }

            $element->imageDynamicRelation($type)->delete();
            $element->imageDynamicRelation($type)->save($image);

            return response()->json(['image_id' => $image->id]);
        }
    }
    
    /**
     * Удаляет изображение.
     * 
     * @param ImageRequest $request
     * @return Response
     */
    public function delete(ImageRequest $request)
    {
        $image = Image::findOrFail((int) $request->image_id);
        $image->delete();
        
        return response()->json(['success' => 'ok']);
    }
}
