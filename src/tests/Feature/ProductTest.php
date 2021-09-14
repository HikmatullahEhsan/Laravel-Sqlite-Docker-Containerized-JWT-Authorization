<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
class ProductTest extends TestCase
{
    use RefreshDatabase;
    private $productId = null;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testProductCreation()
    {
        $response = $this->json('POST', '/api/v1/products', ['name' => 'Sally','sku'=>'Test']);

        $response->assertStatus(201)->assertJson(['code' => 201]);
    }

    /**
     * @return void
     */
    public function testIndexReturnsDataInValidFormat() {

        $this->json('get', '/api/v1/products')
             ->assertStatus(Response::HTTP_OK)
             ->assertJsonStructure(
                 [
                    '*' => [
                        'id',
                        'sku',
                        'name'
                    ]
                 ]
             );
    }


     /**
     * @return void
     */
    public function testReturnSingleRecord() {

        $this->json('get', '/api/v1/products')
             ->assertStatus(Response::HTTP_OK)
             ->assertJsonStructure(
                 [
                    '*' => [
                        'id',
                        'sku',
                        'name'
                    ]
                 ]
             );
    }
}
