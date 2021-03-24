<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class DeleteProductCommand extends Command
{
    /**
     * Product service
     * 
     * @var \App\Services\ProductService
     */
    private $productService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a product';

    /**
     * Create a new command instance.
     *
     * @param \App\Services\ProductService $productService
     * @return void
     */
    public function __construct(ProductService $productService)
    {
        parent::__construct();

        $this->productService = $productService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try{
            $this->listProducts();
            $productID = $this->getProductID();
            $this->productService->delete($productID);
            $this->info('Product deleted successfully.');
            $this->listProducts();
        }catch(Exception $ex){
            Log::error("Unable delete a product, details: {$ex->getMessage()}");

            $this->error($ex->getMessage());
        }
    }

    /**
     * Get product ID from console
     * 
     * @return int
     */
    private function getProductID() : int
    {
        $id = $this->ask('Enter ID of product you want to delete: ');

        while(!is_int($id)){
            $id = $this->ask('Enter ID of product you want to delete: ');
        }

        return $id;
    }
    
    /**
     * Display products on the console
     * 
     * @return void
     */
    private function listProducts()
    {
        // Init
        $headers = ['ID', 'Name', 'Price'];
        
        $this->info('List of all products: ');
        $this->table($headers, $this->productService->all()->only(['id', 'name', 'price']));
    }
}
