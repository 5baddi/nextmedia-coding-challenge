<?php

namespace App\Services;

use Exception;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\ProductsRepository;
use Illuminate\Support\Facades\Validator;
use App\Repositories\CategoriesRepository;
use Illuminate\Validation\ValidationException;

class ProductService
{
    /**
     * Product repository
     *
     * @var \App\Repositories\ProductsRepository
     */
    protected $productRepository;

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
     * Storage service
     *
     * @var \App\Services\StorageService
     */
    protected $storage;

    /**
     * Constructor
     *
     * @param ProductsRepository $productRepository
     */
    public function __construct(ProductsRepository $productRepository, CategoriesRepository $categoryRepository, Validator $validator, StorageService $storage)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->validator = $validator;
        $this->storage = $storage;
    }

    /**
     * Retrieve all products
     * 
     * @return Collection
     */
    public function all()
    {
        return $this->productRepository->all();
    }

    /**
     * Retrieve all products with relationships
     * 
     * @return Collection
     */
    public function withRelationships()
    {
        return $this->productRepository->with(['categories']);
    }
    
    /**
     * Retrieve all products by category
     * 
     * @param int $category Category
     * @return Collection
     * @throws \Exception
     */
    public function byCategory(int $category)
    {
        $existsCategory = $this->categoryRepository->find($category);
        if(!$existsCategory instanceof Category){
            throw new Exception("Category not exists!");
        }

        return $this->productRepository->byCategory($category);
    }

    /**
     * Create new product
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model|bool
     * @throws \ValidationException|\Exception
     */
    public function create(array $data)
    {
        // Validate data
        $validator = $this->validator::make($data, [
                            'name'          =>  'required|max:255',
                            'description'   =>  'nullable|string',
                            'price'         =>  'required|numeric',
                            'image'         =>  'nullable|image|max:2048',
                        ]);

        if($validator->fails()){
            throw new ValidationException($validator->errors()->all());
        }

        $existsProduct = $this->productRepository->findByName($data['name']);
        if($existsProduct instanceof Product){
            throw new Exception("Product already exists with name {$data['name']}");
        }

        // Upload product image
        if(isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile){
            try{
                // Generate file name
                $fileName = Str::slug($data['name']) . '_' . time();
                // Upload image to storage
                $data['image'] = $this->storage->upload($data['image'], 'uploads/products', $fileName);
            }catch(Exception $ex){
                Log::error("Unable to upload product image, details: {$ex->getMessage()}");
    
                throw new Exception("Unable to upload product image!");
            }
        }

        return $this->productRepository->create($data);
    }
    
    /**
     * Delete product by ID
     *
     * @param int $id Id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id): bool
    {
        try{
            DB::beginTransaction();

            $product = $this->productRepository->find($id);
            if(!$product instanceof Product){
                throw new Exception("Unable to find product with ID: {$id} !");
            }

            $deleted = $this->productRepository->delete($product);
            DB::commit();

            return $deleted;
        }catch(Exception $ex){
            DB::rollBack();
            Log::error("Unable to delete product ID:{$product->id}, details: {$ex->getMessage()}");

            throw new Exception("Unable to delete this product!");
        }
    }
}