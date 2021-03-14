<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CreateProductCommand extends Command
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
    protected $signature = 'create:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new product';

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
            // Ask for product data
            $data = $this->getProductData();
            // Create new product
            $createdProduct = $this->productService->create($data);
            // Display created product
            if($createdProduct !== false)
                $this->displayProduct($createdProduct);
        }catch(Exception $ex){
            // Trace error
            Log::error("Unable create a new product, details: {$ex->getMessage()}");

            $this->error('Unable create a new product!');
        }
    }

    /**
     * Get product data from console
     * 
     * @return array
     */
    private function getProductData() : array
    {
        // Init
        $data = [];

        $data['name'] = $this->ask('Enter product name: ');
        $data['description'] = $this->ask('Enter product description: ');
        $data['price'] = $this->ask('Enter product price: ');

        return $data;
    }
    
    /**
     * Display product data on the console
     * 
     * @param \Illuminate\Database\Eloquent\Model $product
     * @return void
     */
    private function displayProduct(Model $product)
    {
        // Init
        $headers = ['Name', 'Description', 'Price'];
        $data = [
            'Name'          =>  $product->name,
            'Description'   =>  $product->description,
            'Price'         =>  $product->price
        ];
        
        $this->info('Product created successfully.');
        // Show product on table
        $this->table($headers, [$data]);
    }
}
