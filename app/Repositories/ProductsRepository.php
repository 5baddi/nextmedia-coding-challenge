<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\AbstractRepository;

class ProductsRepository extends AbstractRepository
{
    /**
     * Model
     *
     * @return \App\Models\Product
     */
    protected $model;

    /**
     * Construct
     * 
     * @param \App\Models\Product $model Model
     * @return void
     */
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    /**
     * Find row by name key
     *
     * @param string $name Name
     * @return \App\Models\Product|null
     */
    public function findByName(string $name): ?Product
    {
        $product = $this->where(['name' => $name]);
        if($product instanceof \Illuminate\Database\Eloquent\Builder){
            return $product->first();
        }

        return null;
    }
    
    /**
     * Filter by category
     *
     * @param int $category Category
     * @return \lluminate\Support\Collection
     */
    public function byCategory(int $category): Collection
    {
        $result = $this->model::whereHas('categories', function($query) use($category){
                            $query->where('category_id', $category);
                        })
                        ->get();

        return $result;
    }
}