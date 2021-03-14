<?php

namespace App\Repositories;

use App\Models\Product;
use Torann\LaravelRepository\Repositories\AbstractRepository;

class ProductsRepository extends AbstractRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    protected $model = Product::class;
}