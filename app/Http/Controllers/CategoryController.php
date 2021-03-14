<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;

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
     * Store a new category.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
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
            $categoryService->create($data);

            return response()->success("{$data['name']} created successfully.");
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
}
