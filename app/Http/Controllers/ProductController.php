<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\ProductService;
use Illuminate\Validation\ValidationException;
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
        return response()->json($this->productService->all());
    }

     /**
     * Store a new product
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \ValidationException|\Exception
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
            $createdProduct = $this->productService->create($data);

            return response()->json($createdProduct, Response::HTTP_CREATED);
        }catch(ValidationException $ex){
            return response()->json(
                [
                    'message' => 'Something going wrong! can\'t create new product',
                    'error'   => $ex->getMessage() 
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }catch(Exception $ex){
            return response()->json(
                [
                    'message' => 'Something going wrong! can\'t create new product',
                    'error'   => $ex->getMessage() 
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

     /**
     * Delete product
     *
     * @param int $id Id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        try{
            $this->productService->delete($id);

            return response()->json([], Response::HTTP_NO_CONTENT);
        }catch(Exception $ex){
            return response()->json(
                [
                    'message' => 'Something going wrong! can\'t create new category',
                    'error'   => $ex->getMessage() 
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
