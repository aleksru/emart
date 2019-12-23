<?php


namespace Modules\Category\Repository;


use Kalnoy\Nestedset\Collection;
use Modules\Category\Entities\Category;

class CategoryRepository
{
    /**
     * Получить дерево категорий
     * @return Collection
     */
    public function buildTree() : Collection
    {
        return Category::active()->get()->toTree();
    }
}