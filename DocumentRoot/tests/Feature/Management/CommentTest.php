<?php

namespace Tests\Feature\Management;

use Tests\TestCase;

class CommentTest extends TestCase
{
    /**
     * Update comment test
     *
     * @return void
     */
    public function testUpdateComment()
    {
        $response = $this->json('PUT', '/api/v1/management/comments/1', ['approve' => 1]);

        $response->assertStatus(200);
    }
}
