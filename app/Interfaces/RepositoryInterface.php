<?php

namespace App\Interfaces;


use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

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
     * Find row by key
     * 
     * @param int $id Id
     * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function find(int $id): ?Model;

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