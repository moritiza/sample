<?php

namespace Tests\Feature\Management;

use Tests\TestCase;

class VoteTest extends TestCase
{
    /**
     * Update vote test
     *
     * @return void
     */
    public function testUpdateVote()
    {
        $response = $this->json('PUT', '/api/v1/management/votes/1', [
            'approve' => 1,
            'vote' => 4,
        ]);

        $response->assertStatus(200);
    }
}
