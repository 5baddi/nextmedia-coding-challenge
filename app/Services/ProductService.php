<?php

namespace App\Services;

use App\Repositories\ProductsRepository;

class ProductService
{
    /**
     * Product repository
     *
     * @var \App\Repositories\ProductsRepository
     */
    protected $productRepository;

    /**
     * Constructor
     *
     * @param ProductsRepository $productRepository
     */
    public function __construct(ProductsRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
}