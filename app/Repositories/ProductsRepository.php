<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Collection;
use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ProductsRepository implements RepositoryInterface
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
     * Retrieve all rows
     * 
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model::all();
    }

   /**
    * Find row by id key
    *
    * @param int $id Id
    * @return \App\Models\Product|null
    */
    public function find(int $id): ?Product
    {
        return $this->model::find($id);
    }

    /**
     * Insert new row
     * 
     * @param array $attributes Attributes
     * @return \App\Models\Product
    */
    public function create(array $attributes): Product
    {
        return $this->model->create($attributes);
    }

    /**
     * Update exists row
     * 
     * @param \App\Models\Product $entity Entity
     * @param array $attributes Attributes
     * @return bool
    */
   public function update(Model $entity, array $attributes): bool
   {
       return $entity->update($attributes);
   }

   /**
     * Delete exists row
     * 
     * @param \App\Models\Product $entity Entity
     * @return bool|null
    */
    public function delete(Model $entity): ?bool
    {
        return $entity->delete();
    }
}