<?php

namespace App\Repositories;

use App\Models\Category;
use Torann\LaravelRepository\Repositories\AbstractRepository;

class CategoriesRepository extends AbstractRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    protected $model = Category::class;
}