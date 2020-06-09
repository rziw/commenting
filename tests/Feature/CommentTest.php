<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /** @test */
    public function user_can_comment_on_a_post()
    {
        $this->withoutExceptionHandling();
        $this->be(factory('App\User')->create());
        $post = factory('App\Models\Post')->create();

        $attributes = [
            'description' => $this->faker->text(),
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name
        ];

        $response = $this->post("posts/$post->id/comments", $attributes);

        $this->assertDatabaseHas('comments', $attributes);
        $response->assertRedirect('/posts/'.$post->id);
        $this->get("/posts/$post->id")->assertSeeText($attributes['description']);
    }
}
