<?php

namespace App\Services;

use Exception;
use App\Models\Product;
use App\Traits\UploadTrait;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\ProductsRepository;
use Illuminate\Support\Facades\Validator;

class ProductService
{
    use UploadTrait;

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
     * Retrieve list of products
     * 
     * @return array
     */
    public function list()
    {
        return $this->productRepository->all(['id', 'name', 'price'])->toArray();
    }

    /**
     * Create new product
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model|bool
     * @throws \InvalidArgumentException
     */
    public function create(array $data)
    {
        // Validate data
        $validator = Validator::make($data, [
            'name'          =>  'required|unique:products|max:255',
            'description'   =>  'nullable|string',
            'price'         =>  'required|numeric',
            'image'         =>  'nullable|image|max:2048',
        ]);

        // Throw exception if validation fails
        if($validator->fails())
            throw new InvalidArgumentException($validator->errors()->first());

        // Upload product image
        if(isset($data['image']) && is_a($data['image'], \Illuminate\Http\UploadedFile::class)){
            try{
                // Generate file name
                $fileName = Str::slug($data['name']) . '_' . time();
                // Upload image to storage
                $data['image'] = $this->upload($data['image'], 'uploads/products', $fileName);
            }catch(Exception $ex){
                // Trace error
                Log::error("Unable to upload product image, details: {$ex->getMessage()}");
    
                // Throw exception
                throw new Exception("Unable to upload product image!");
            }
        }

        return $this->productRepository->create($data);
    }

    /**
     * Delete product
     *
     * @param \App\Models\Product $product
     * @return bool
     * @throws \Exception
     */
    public function delete(Product $product)
    {
        // Start DB transaction
        DB::beginTransaction();

        try{
            // Delete product entity
            $deleted = $this->productRepository->delete($product);
        }catch(Exception $ex){
            // Rollback if something going wrong
            DB::rollBack();
            // Trace error
            Log::error("Unable to delete product ID:{$product->id}, details: {$ex->getMessage()}");

            // Throw exception
            throw new Exception("Unable to delete this product!");
        }

        // Commit DB transaction
        DB::commit();

        return $deleted ?? false;
    }
    
    /**
     * Delete product by ID
     *
     * @param int $ID
     * @return bool
     * @throws \Exception
     */
    public function deleteByID(int $ID)
    {
        // Start DB transaction
        DB::beginTransaction();

        try{
            // Find product
            $product = $this->productRepository->find($ID);
            if(!$product || is_null($product))
                throw new Exception("Unable to find product with ID: {$ID} !");

            // Delete product entity
            $deleted = $this->productRepository->delete($product);
        }catch(Exception $ex){
            // Rollback if something going wrong
            DB::rollBack();
            // Trace error
            Log::error("Unable to delete product ID:{$product->id}, details: {$ex->getMessage()}");

            // Throw exception
            throw new Exception("Unable to delete this product!");
        }

        // Commit DB transaction
        DB::commit();

        return $deleted ?? false;
    }
}