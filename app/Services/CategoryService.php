<?php

namespace App\Services;

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
}