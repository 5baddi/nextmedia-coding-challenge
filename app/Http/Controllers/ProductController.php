<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Services\ProductService;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Product service
     * 
     * @var \App\Services\ProductService
     */
    private $productService;

    /**
     * Constructor
     *
     * @param \App\Services\ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Retrieve all products
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->success(
            "All products retrieved successfully.",
            $this->productService->all()
        );
    }

     /**
     * Store a new product
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \InvalidArgumentException|\Exception
     */
    public function store(Request $request)
    {
        // Get data
        $data = $request->only([
            'name',
            'description',
            'price',
            'image',
        ]);

        try{
            // Save new product
            $createdProduct = $this->productService->create($data);

            return response()->success("Product created successfully.", $createdProduct);
        }catch(InvalidArgumentException $ex){
            return response()->error(
                "Something going wrong! can't create new product",
                [$ex->getMessage()],
                422
            );
        }catch(Exception $ex){
            return response()->error(
                "Something going wrong! can't create new product",
                [$ex->getMessage()]
            );
        }
    }

     /**
     * Delete product
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        try{
            // Delete targeted product
            $this->productService->delete($product);

            return response()->success("Product deleted successfully.", null, Response::HTTP_NO_CONTENT);
        }catch(Exception $ex){
            return response()->error(
                "Something going wrong! can't delete the product",
                [$ex->getMessage()]
            );
        }
    }
}
