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
        $this->be(factory('App\User')->create());
        $attributes = factory('App\Models\Comment')->raw();

        $response = $this->post("posts/".$attributes['post_id']."/comments",
            ['description' => $attributes['description']]);

        $this->assertDatabaseHas('comments', $attributes);
        $response->assertRedirect('/posts/'.$attributes['post_id']);
        $this->get("/posts/".$attributes['post_id'])->assertSeeText($attributes['description']);
    }

    /** @test */
    public function only_authenticated_users_can_comment()
    {
        $attributes = factory('App\Models\Comment')->raw();

        $this->post("posts/".$attributes['post_id']."/comments", $attributes)->assertRedirect('login');
    }

}
