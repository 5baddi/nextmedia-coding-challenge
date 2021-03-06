<?php

namespace App\Services;

use Exception;
use App\Models\Category;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Repositories\CategoriesRepository;
use Illuminate\Validation\ValidationException;

class CategoryService
{
    /**
     * Category repository
     *
     * @var \App\Repositories\CategoriesRepository
     */
    protected $categoryRepository;
    
    /**
     * Validator package
     *
     * @var \Illuminate\Support\Facades\Validator
     */
    protected $validator;

    /**
     * Constructor
     *
     * @param CategoriesRepository $categoryRepository
     */
    public function __construct(CategoriesRepository $categoryRepository, Validator $validator)
    {
        $this->categoryRepository = $categoryRepository;
        $this->validator = $validator;
    }
    
    /**
     * Retrieve all categories
     * 
     * @return Collection
     */
    public function all()
    {
        return $this->categoryRepository->all();
    }

    /**
     * Retrieve all categories with relationships
     * 
     * @return Collection
     */
    public function withRelationships()
    {
        return $this->categoryRepository->with(['parent']);
    }

    /**
     * Create new category
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model|bool
     * @throws \InvalidArgumentException
     */
    public function create(array $data)
    {
        $validator = $this->validator::make($data, [
            'name'                  =>  'required|max:255',
            'parent_category_id'    =>  'nullable|exists:categories,id',
        ]);

        if($validator->fails()){
            throw new ValidationException($validator->errors()->all());
        }

        $existsCategory = $this->categoryRepository->findByName($data['name']);
        if($existsCategory instanceof Category){
            throw new Exception("Category already exists with name {$data['name']}");
        }

        return $this->categoryRepository->create($data);
    }

    /**
     * Delete category by id
     *
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id): bool
    {
        try{
            DB::beginTransaction();

            $category = $this->categoryRepository->find($id);
            if(!$category instanceof Category){
                throw new Exception("Unable to find category with ID: {$id} !");
            }

            $deleted = $this->categoryRepository->delete($category);
            DB::commit();

            return $deleted;
        }catch(Exception $ex){
            DB::rollBack();
            Log::error("Unable to delete category ID:{$category->id}, details: {$ex->getMessage()}");

            throw new Exception("Unable to delete this category!");
        }
    }
}