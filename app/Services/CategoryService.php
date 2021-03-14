<?php

namespace App\Services;

use Exception;
use App\Models\Category;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Repositories\CategoriesRepository;

class CategoryService
{
    /**
     * Category repository
     *
     * @var \App\Repositories\CategoriesRepository
     */
    protected $categoryRepository;

    /**
     * Constructor
     *
     * @param CategoriesRepository $categoryRepository
     */
    public function __construct(CategoriesRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Create new category
     *
     * @param array $data
     * @throws \InvalidArgumentException
     */
    public function create(array $data)
    {
        // Validate data
        $validator = Validator::make($data, [
            'name'                  =>  'required|unique:categories|max:255',
            'parent_category_id'    =>  'nullable|exists:categories,id',
        ]);

        // Throw exception if validation fails
        if($validator->fails())
            throw new InvalidArgumentException($validator->errors()->first());

        return $this->categoryRepository->create($data);
    }

    /**
     * Delete category
     *
     * @param \App\Models\Category $category
     * @return boolean
     * @throws \Exception
     */
    public function delete(Category $category)
    {
        // Start DB transaction
        DB::beginTransaction();

        try{
            // Delete category entity
            $deleted = $this->categoryRepository->delete($category);
        }catch(Exception $ex){
            // Rollback if something going wrong
            DB::rollBack();
            // Trace error
            Log::error("Unable to delete category ID:{$category->id} details: {$ex->getMessage()}");

            // Throw exception
            throw new Exception("Unable to delete this category!");
        }

        // Commit DB transaction
        DB::commit();

        return $deleted ?? false;
    }
}