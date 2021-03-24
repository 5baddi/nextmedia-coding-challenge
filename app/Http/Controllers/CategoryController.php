<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Category service
     * 
     * @var \App\Services\CategoryService
     */
    private $categoryService;

    /**
     * Constructor
     *
     * @param \App\Services\CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Store a new category
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
            'parent_category_id'
        ]);

        try{
            $createdCategory = $this->categoryService->create($data);

            return response()->json($createdCategory);
        }catch(ValidationException $ex){
            return response()->json(
                [
                    'message' => 'Something going wrong! can\'t create new category',
                    'error'   => $ex->getMessage() 
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
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

    /**
     * Delete category
     *
     * @param int $id Id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        try{
            $this->categoryService->delete($id);

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
