<?php

namespace App\Interfaces;


use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
* Interface RepositoryInterface
* @package App\Repositories
*/
interface RepositoryInterface
{
    /**
     * Retrieve all rows
     * 
     * @return \Illuminate\Support\Collection
    */
    public function all(): Collection;

    /**
     * Retrieve all rows with relationships
     * 
     * @param array $relationships Relationships
     * @return \lluminate\Support\Collection
     */
    public function with(array $relationships): Collection;

    /**
     * Find row by key
     * 
     * @param int $id Id
     * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function find(int $id): ?Model;

    /**
    * Where closure
    *
    * @param array $conditions Conditions
    * @return \Illuminate\Database\Eloquent\Builder|null
    */
    public function where(array $conditions): ?Builder;

    /**
     * Insert new row
     * 
     * @param array $attributes Attributes
     * @return \Illuminate\Database\Eloquent\Model
    */
    public function create(array $attributes): Model;

    /**
     * Update exists row
     * 
     * @param \Illuminate\Database\Eloquent\Model $entity Entity
     * @param array $attributes Attributes
     * @return bool
    */
   public function update(Model $entity, array $attributes): bool;
   
   /**
     * Delete exists row
     * 
     * @param \Illuminate\Database\Eloquent\Model $entity Entity
     * @return bool|null
    */
   public function delete(Model $entity): ?bool;
}