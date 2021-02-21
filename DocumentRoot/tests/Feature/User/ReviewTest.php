<?php

namespace Tests\Feature\User;

use Tests\TestCase;

class ReviewTest extends TestCase
{
    /**
     * Product control test
     *
     * @return void
     */
    public function testProductControl()
    {
        $response = $this->get('/api/v1/user/products/1/control');

        $response->assertStatus(200);
    }
}
