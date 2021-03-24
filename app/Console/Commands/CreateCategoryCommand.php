<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CreateCategoryCommand extends Command
{
    /**
     * Product service
     * 
     * @var \App\Services\CategoryService
     */
    private $categoryService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new category';

    /**
     * Create a new command instance.
     *
     * @param \App\Services\CategoryService $categoryService
     * @return void
     */
    public function __construct(CategoryService $categoryService)
    {
        parent::__construct();

        $this->CategoryService = $categoryService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try{
            $this->listCategories();
            $data = $this->getCategoryData();
            $createdCategory = $this->categoryService->create($data);
            $this->displayCategory($createdCategory);
        }catch(Exception $ex){
            Log::error("Unable create a new category, details: {$ex->getMessage()}");

            $this->error('Unable create a new category!');
        }
    }

    /**
     * Get category data from console
     * 
     * @return array
     */
    private function getCategoryData() : array
    {
        // Init
        $data = [];

        $data['name'] = $this->ask('Enter category name: ');
        $data['parent_category_id'] = $this->ask('Enter parent category ID: ');

        return $data;
    }
    
    /**
     * Display category data on the console
     * 
     * @param \Illuminate\Database\Eloquent\Model $category
     * @return void
     */
    private function displayCategory(Model $category)
    {
        // Init
        $headers = ['Name'];
        $data = [
            'Name'          =>  $category->name
        ];
        
        $this->info('Category created successfully.');
        $this->table($headers, [$data]);
    }

     /**
     * Display categories on the console
     * 
     * @return void
     */
    private function listCategories()
    {
        // Init
        $headers = ['ID', 'Name'];
        
        $this->info('List of all categories: ');
        $this->table($headers, $this->categoryService->all()->only(['id', 'name']));
    }
}
