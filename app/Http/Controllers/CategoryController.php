<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Services\CategoryService;
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
     * @throws \InvalidArgumentException|\Exception
     */
    public function store(Request $request)
    {
        // Get data
        $data = $request->only([
            'name',
            'parent_category_id'
        ]);

        try{
            // Save new category
            $this->categoryService->create($data);

            return response()->success("Category created successfully.");
        }catch(InvalidArgumentException $ex){
            return response()->error(
                "Something going wrong! can't create new category",
                [$ex->getMessage()],
                422
            );
        }catch(Exception $ex){
            return response()->error(
                "Something going wrong! can't create new category",
                [$ex->getMessage()]
            );
        }
    }

    /**
     * Delete category
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     * @throws \InvalidArgumentException|\Exception
     */
    public function destroy(Category $category)
    {
        try{
            // Delete targeted category
            $this->categoryService->delete($category);

            return response()->success("Category deleted successfully.", null, Response::HTTP_NO_CONTENT);
        }catch(Exception $ex){
            return response()->error(
                "Something going wrong! can't delete the category",
                [$ex->getMessage()]
            );
        }
    }
}
