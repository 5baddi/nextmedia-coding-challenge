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
    protected $signature = 'delete:product';

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
            // Show list of products
            $this->listProducts();
            // Ask for product ID need to delete
            $productID = $this->getProductID();
            // Delete product
            if($this->productService->deleteByID($productID)){
                $this->info('Product deleted successfully.');

                // Show list of products
                $this->listProducts();
            }else{
                $this->error('Unable to delete this product!');
            }
                
        }catch(Exception $ex){
            // Trace error
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
        // Show products on table
        $this->table($headers, $this->productService->list());
    }
}
