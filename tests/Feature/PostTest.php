<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_a_post()
    {
        $attributes = [
            'title'                 => 'test post',
            'description'           => 'example test fake',
        ];

        $response = $this->post('/posts', $attributes);

        $this->assertDatabaseHas('posts', $attributes);

        $response->assertRedirect('/posts');
    }
}
