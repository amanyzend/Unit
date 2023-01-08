<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

class BaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * @param array $unit
     * @return \Illuminate\Testing\TestResponse
     */
    protected function createUnit(array $unit): \Illuminate\Testing\TestResponse
    {
        $response = $this->post('units', $unit);
        $this->assertDatabaseHas('units', $unit);
        $response->assertStatus(200);
        return $response;
    }

    /**
     * @param array $product
     * @return \Illuminate\Testing\TestResponse
     */
    protected function createProduct(array $product): \Illuminate\Testing\TestResponse
    {
        $response = $this->post('products', $product);
        $this->assertDatabaseHas('products', $product);
        $response->assertStatus(200);
        return $response;
    }

    /**
     * @param array $image
     * @return \Illuminate\Testing\TestResponse
     */
    protected function createImage(array $image): \Illuminate\Testing\TestResponse
    {
        $response = $this->post('images', $image);
        $this->assertDatabaseHas('images', Arr::only($image, ['path', 'description']));
        $response->assertOk();
        return $response;
    }

    protected function createUser(array $user): \Illuminate\Testing\TestResponse
    {
        $response = $this->post('users', $user);
        $this->assertDatabaseHas('users', $user);
        $response->assertOk();
        return $response;
    }
}
