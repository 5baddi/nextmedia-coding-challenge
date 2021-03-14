<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class DeleteCategoryCommand extends Command
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
    protected $signature = 'delete:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a category';

    /**
     * Create a new command instance.
     *
     * @param \App\Services\CategoryService $categoryService
     * @return void
     */
    public function __construct(CategoryService $categoryService)
    {
        parent::__construct();

        $this->categoryService = $categoryService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try{
            // Show list of categories
            $this->listCategories();
            // Ask for category ID need to delete
            $categoryID = $this->getCategoryID();
            // Delete product
            if($this->categoryService->deleteByID($categoryID)){
                $this->info('Category deleted successfully.');

                // Show list of categories
                $this->listCategories();
            }else{
                $this->error('Unable to delete this category!');
            }
                
        }catch(Exception $ex){
            // Trace error
            Log::error("Unable delete a category, details: {$ex->getMessage()}");

            $this->error($ex->getMessage());
        }
    }

    /**
     * Get category ID from console
     * 
     * @return int
     */
    private function getCategoryID() : int
    {
        $id = $this->ask('Enter ID of category you want to delete: ');

        while(!is_int($id)){
            $id = $this->ask('Enter ID of category you want to delete: ');
        }

        return $id;
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
        // Show categories on table
        $this->table($headers, $this->categoryService->list());
    }
}
