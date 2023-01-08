<?php

namespace Tests\Feature\TaskOne;

use Tests\Feature\BaseTest;

class UnitTest extends BaseTest
{
    public function test_create_unit()
    {
        $unit1 = [
            'name' => 'Gram',
            'modifier' => 1,
        ];
        $this->createUnit($unit1);

        $unit2 = [
            'name' => 'Kilo Gram',
            'modifier' => 1000,
        ];
        $this->createUnit($unit2);
    }
}
