<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Collection;
use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CategoriesRepository implements RepositoryInterface
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
    * @return \App\Models\Category|null
    */
    public function find(int $id): ?Category
    {
        return $this->model::find($id);
    }
    
    /**
    * Find row by name key
    *
    * @param string $name Name
    * @return \App\Models\Category|null
    */
    public function findByName(string $name): ?Category
    {
        return $this->model::where('name', $name)->first();
    }

    /**
     * Insert new row
     * 
     * @param array $attributes Attributes
     * @return \App\Models\Category
    */
    public function create(array $attributes): Category
    {
        return $this->model->create($attributes);
    }

    /**
     * Update exists row
     * 
     * @param \App\Models\Category $entity Entity
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
     * @param \App\Models\Category $entity Entity
     * @return bool|null
    */
    public function delete(Model $entity): ?bool
    {
        return $entity->delete();
    }
}