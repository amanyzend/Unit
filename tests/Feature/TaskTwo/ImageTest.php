<?php

namespace Tests\Feature\TaskTwo;

use Tests\Feature\BaseTest;

class ImageTest extends BaseTest
{
    public function test_adding_images()
    {
        $this->createProduct(['name' => 'Apple']);
        $this->createImage([
            'o_id' => 1,
            'o_type' => 'product',
            'path' => 'apple.jpg',
            'description' => 'image of an apple'
        ]);
        $response = $this->get('products/1');
        $this->assertEquals('apple.jpg', $response->json('image_path'));

        $this->createUser(['name' => 'Bilal', 'email' => 'b@mail.com', 'password' => '123']);
        $this->createImage([
            'o_id' => 1,
            'o_type' => 'user',
            'path' => 'bilal.jpg',
            'description' => 'image of a Bilal'
        ]);
        $response = $this->get('users/1');
        $this->assertEquals('bilal.jpg', $response->json('image_path'));
    }

}
