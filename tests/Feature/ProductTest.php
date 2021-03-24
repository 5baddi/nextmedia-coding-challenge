<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ProductTest extends TestCase
{
    /**
     * Unit test for creating new product
     *
     * @return void
     */
    public function test_create_product()
    {
        $response = $this->post(route('api.product.fetch'), [
            'name'          =>  'Test product ' . uniqid(),
            'description'   =>  Str::random(25),
            'price'         =>  10.1,
            
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }
}
