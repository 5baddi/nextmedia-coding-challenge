<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class AbstractRepository implements RepositoryInterface
{
    /**
     * Model
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Constructor
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve all rows
     * 
     * @return \lluminate\Support\Collection
     */
    public function all(): Collection
    {
        return $this->model::all();
    }

    /**
     * Find row by id key
     *
     * @param int $id Id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->model::find($id);
    }

    /**
    * Where closure
    *
    * @param array $conditions Conditions
    * @return \Illuminate\Database\Eloquent\Builder|null
    */
    public function where(array $conditions): ?Builder
    {
        return $this->model::where($conditions);
    }

    /**
     * Insert new row
     * 
     * @param array $attributes Attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * Update exists row
     * 
     * @param \Illuminate\Database\Eloquent\Model $entity Entity
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
     * @param \Illuminate\Database\Eloquent\Model $entity Entity
     * @return bool|null
     */
    public function delete(Model $entity): ?bool
    {
        return $entity->delete();
    }
}