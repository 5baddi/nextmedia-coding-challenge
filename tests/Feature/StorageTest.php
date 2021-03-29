<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;

class StorageTest extends TestCase
{
    /**
     * Filesystem service
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $storage;

    /**
     * Setup the test environment
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->storage = $this->app->make('App\Services\StorageService');
    }

    /**
     * Unit test for creating new product
     *
     * @return void
     */
    public function test_get_file_url()
    {
        $product = Product::whereNotNull('image')->inRandomOrder()->first();
        if($product instanceof Product){
            $publicURL = $this->storage->url($product->image);

            $this->assertNotNull($publicURL);
        }else{
            $this->assertNull(null, 'No record to tested!');
        }
    }
}