<?php

namespace Modules\Media\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Image extends Model
{
    /**
     * папка изображений относительно публичной папки Laravel
     */
    const BASE_PATH = "uploads/images";

    /** @var string */
    protected $table = 'images';

    /** @var array */
    protected $guarded = ['id'];

    /** @var array */
    protected $casts = [
        'images_attributes' => 'array',
    ];
    
    /** @var array */
    protected $appends = [
        'size'
    ];
    
    /** @var array */
    protected $hidden = [
        'morph_id', 'morph_type'
    ];

    /**
     * Нужно явно указать все атрибуты модели, так как внутри идет
     * переопределение несуществующих свойств на отношения.
     * Все несуществующие свойства рассматриваются как отношения.
     * 
     * @var array 
     */
    protected $attributes = [
        'id' => null, 'parent_id' => null, 'path' => null, 'width' => null, 'height' => null, 
        'modifier' => null, 'type' => null, 'image_attributes' => null, 'morph_id' => null,
        'morph_type' => null, 'created_at' => null, 'updated_at' => null
    ];

    /**
     * Возвращает размер файла на диске.
     * 
     * @return int
     */
    public function getSizeAttribute()
    {
        if (file_exists(public_path($this->path)))
            return filesize(public_path($this->path));
        
        return 0;
    }

    /**
     * Возвращает все дочерние изображения (например, thumbnails).
     * 
     * @param $modifier
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children($modifier = null)
    {
        $builder = $this->hasMany(Image::class, 'parent_id');
        
        if ($modifier) 
            $builder->where('modifier', $modifier);
        
        return $builder;
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (in_array($method, ['increment', 'decrement'])) {
            return $this->$method(...$parameters);
        }

        /**
         * Перенаправляем все не существующие методы QueryBuilder на отношения.
         * Если это не магия QueryBuilder, тогда это modifier.
         */
        try {
            return $this->newQuery()->$method(...$parameters);
        }
        catch (\BadMethodCallException $exception) {
            return $this->children($method);
        }
    }

    /**
     * Переопределенный метод для нахождения отношений по ключу.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getRelationValue($key)
    {
        // If the key already exists in the relationships array, it just means the
        // relationship has already been loaded, so we'll just return it out of
        // here because there is no need to query within the relations twice.
        if ($this->relationLoaded($key)) {
            return $this->relations[$key];
        }
        
        /**
         * Важный момент!
         * Все несуществующие атрибуты рассматриваем как отношения.
         * Это нужно для динамической подгрузки модификаторов изображений.
         * @see $attributes
         */
        return $this->getRelationshipFromMethod($key);
    }
    

    /**
     * Создает изображение из загруженного файла.
     *
     * @param UploadedFile $file
     * @param string $type
     * @param int|null $maxWidth
     * @param int|null $maxHeight
     * @param array $attributes
     *
     * @return \Modules\Media\Models\Image
     * @throws \Exception
     */
    public static function createFromImage(
        UploadedFile $file,
        string $type,
        int $maxWidth = null,
        int $maxHeight = null,
        array $attributes = null
    )
    {
        // для создания папки изображения сначала надо создать
        // запись изображения в БД, чтобы получить его ID

        /** @var \Modules\Media\Models\Image $image */
        $image = self::create();
        try {
            /** @var \Intervention\Image\Image $img */
            $img = \Image::make($file);
            if ($maxWidth || $maxHeight) {
                $img->resize($maxWidth, $maxHeight, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }
            
            $directory         = self::BASE_PATH . self::getPath($image->id);

            $fullDirectoryPath = public_path($directory);
            @mkdir($fullDirectoryPath, 0777, true);
         
            $fileName = uniqid() . '.' . $file->clientExtension();
            $img->save($fullDirectoryPath . '/' . $fileName);
                 
            $image->type        = $type;
            $image->path        = $directory . '/' . $fileName;
            $image->width       = $img->width();
            $image->height      = $img->height();
            
            if(!empty($attributes)){
                $image->image_attributes = $attributes;
            }

            $image->save();

            return $image;
        } catch (\Exception $e) {
            // Если что-то не так
            // то удалим пустую запись из БД
            $image->delete();
            throw $e;
        }
    }

    /**
     * Обрезка/ресайз изображения
     *
     * @param int|null $width
     * @param int|null $height
     * @param string $modifier - модификатор изображения
     *
     * @return Image
     * @throws \Exception
     */
    public function fit($width, $height, $modifier = null)
    {
        // Проверим возможноть ресайза/обрезки
        $this->checkFit($width, $height);

        $parentPath = $this->getParentImagePath();

        //условия при котором можно вернуть оригинал: если ширина и высота картинки совпадают с заданными
        if ($this->width === $width && $this->height === $height) 
            return $this;

        $modifier = $modifier ?? self::getModifier($width, $height);

        //поиск в базе
        /** @var \App\Models\Image|null $ormImage */
        $ormImage = $this->children()
            ->where('type', '=', $this->type)
            ->where('modifier', '=', $modifier)
            ->first();

        if ($ormImage) 
            return $ormImage;

        //создаем копию, задаем размеры и сохраняем в файловую систему

        /** @var \Intervention\Image\Image $image */
        $image = \Image::make($parentPath);

        // если ширина или высота null - ро делаем ресайз
        if (is_null($width) || is_null($height)) {
            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        } // иначе если указана ширина и высота - то делаем умную обрезку
        else {
            $image->fit($width, $height, function ($constraint) {
                $constraint->upsize();
            });
        }

        //сохраняем ресайзнутую картинку в файловую систему
        $dir     = pathinfo($this->path, PATHINFO_DIRNAME);
        $ext     = mb_strtolower(pathinfo($this->path, PATHINFO_EXTENSION));
        $name    = pathinfo($this->path, PATHINFO_FILENAME);
        $newPath = "{$dir}/{$name}-{$modifier}.{$ext}";

        $image->save(public_path($newPath));

        //сохраняем ресайзнутую картинку в базу
        return Image::create([
            'path'      => $newPath,
            'width'     => $image->width(),
            'height'    => $image->height(),
            'type'      => $this->type,
            'parent_id' => $this->id,
            'modifier'  => $modifier,
        ]);
    }

    /**
     * Проверка возможности обрезки/ресайза
     *
     * @param $width
     * @param $height
     *
     * @throws \Exception
     */
    private function checkFit($width, $height): void
    {
        // обрезать можем только существующие изобращения
        if (!$this->exists) {
            throw new \Exception("Method 'fit' does not work with a nonexistent image!");
        }

        // обрезать можем только raw изображения
        if (!is_null($this->parent_id)) {
            throw new \Exception("Method 'fit' can not be applied to a child image!");
        }

        // ширина может быть null или положительным целым числом
        if (!is_null($width) && $width <= 0) {
            throw new \Exception('Width must be greater than 0');
        }

        // высота может быть null или положительным целым числом
        if (!is_null($height) && $height <= 0) {
            throw new \Exception('Height must be greater than 0');
        }

        // ширина и высота не могут быть нулевыми одновременно
        if (is_null($width) && is_null($width)) {
            throw new \Exception('width and height can not be null at the same time!');
        }
    }

    /**
     * Возвращает путь родительского изображения.
     * 
     * @return string
     */
    private function getParentImagePath()
    {
        $parentPath = public_path($this->path);

        if (!\File::exists($parentPath)) {
            throw new FileNotFoundException("File {$parentPath} of image id='{$this->id}' not exists!", 504);
        }

        if (!\File::size($parentPath)) {
            throw new FileNotFoundException("File {$parentPath} of image id='{$this->id}' has 0 byte size!", 532);
        }

        return $parentPath;
    }

    /**
     * Получить папку изображения по ID
     *
     * @param int $id
     *
     * @return string
     */
    public static function getPath(int $id)
    {
        $p1 = (int)(ceil($id / 10000) * 10000);
        $p2 = (int)(ceil($id / 100) * 100);

        return "/{$p1}/{$p2}/{$id}";
    }

    /**
     * Формирование модификатора
     *
     * @param $width
     * @param $height
     *
     * @return string
     */
    public static function getModifier($width, $height)
    {
        $modifier = is_null($width) ? "_" : $width;
        $modifier .= "x";
        $modifier .= is_null($height) ? "_" : $height;

        return $modifier;
    }
}
