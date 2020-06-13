<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_user()
    {
        $comment = factory('App\Models\Comment')->make();

        $this->assertInstanceOf('App\User', $comment->user);
    }
}
