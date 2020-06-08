<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $post = factory(\App\Models\Post::class)->make();

        $this->assertInstanceOf('App\User', $post->owner);
    }

    /** @test */
    public function it_belongs_to_a_category()
    {
        $this->withoutExceptionHandling();

        $post = factory(\App\Models\Post::class)->make();

        $this->assertInstanceOf('App\Models\Category', $post->category);
    }
}
