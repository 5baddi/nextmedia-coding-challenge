<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class CategoriesRepository extends AbstractRepository
{
    /**
     * Model
     *
     * @return \App\Models\Category
     */
    protected $model;

    /**
     * Construct
     * 
     * @param \App\Models\Category $model Model
     * @return void
     */
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    /**
     * Find row by name key
     *
     * @param string $name Name
     * @return \App\Models\Category|null
     */
    public function findByName(string $name): ?Category
    {
        $category = $this->where(['name' => $name]);
        if($category instanceof \Illuminate\Database\Query\Builder){
            return $category->first();
        }

        return null;
    }
}