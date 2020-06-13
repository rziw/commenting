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

    /** @test */
    public function comment_requires_description()
    {
        $this->be(factory('App\User')->create());
        $post = factory('App\Models\Post')->create();

        $this->post("posts/".$post->id."/comments", ['description' => null])
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function length_of_description_of_comment_should_be_at_least_ten()
    {
        $this->be(factory('App\User')->create());
        $post = factory('App\Models\Post')->create();

        $this->post("posts/".$post->id."/comments", ['description' => 'abcd'])
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_edit_a_comment()
    {
        $this->be(factory('App\User')->create());

        $attribute = ['description' => 'Changed description'];

        $comment = factory('App\Models\Comment')->create();

        $response = $this->put("posts/".$comment->post_id."/comments/".$comment->id,
            $attribute);

        $this->assertDatabaseHas('comments', $attribute);
        $response->assertRedirect("posts/".$comment->post_id);
        $this->get("/posts/".$comment->post_id)->assertSeeText($attribute['description']);
    }

    /** @test */
    public function only_authenticated_users_can_edit_comment()
    {
        $attribute = ['description' => 'Changed description'];

        $comment = factory('App\Models\Comment')->create();

        $this->put("posts/".$comment->post_id."/comments/".$comment->id,
            $attribute)->assertRedirect('login');
    }

    /** @test */
    public function only_the_owner_of_comment_can_update_it()
    {
        $attribute = ['description' => 'Changed description'];
        $comment = factory('App\Models\Comment')->create();

        $this->be(factory('App\User')->create());

        $this->put("posts/".$comment->post_id."/comments/".$comment->id,
            $attribute)->assertStatus(403);
    }
}
