<?php

namespace App\Services;

use InvalidArgumentException;
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
     * @throws InvalidArgumentException
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
}