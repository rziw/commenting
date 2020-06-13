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
        $comment = factory('App\Models\Comment')->create();

        $this->post("posts/".$comment->post_id."/comments", ['description' => null])
            ->assertSessionHasErrors('description');
        $this->put("posts/".$comment->post_id."/comments/".$comment->id,
            [])->assertSessionHasErrors('description');
    }

    /** @test */
    public function length_of_description_of_comment_should_be_at_least_ten()
    {
        $this->be(factory('App\User')->create());
        $comment = factory('App\Models\Comment')->create();

        $attribute = ['description' => 'abcd'];

        $this->post("posts/".$comment->post_id."/comments", ['description' => $attribute])
            ->assertSessionHasErrors('description');
        $this->put("posts/".$comment->post_id."/comments/".$comment->id,
            $attribute)->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_update_a_comment()
    {
        $this->be(factory('App\User')->create());
        $comment = factory('App\Models\Comment')->create();

        $attribute = ['description' => 'Changed description'];

        $response = $this->put("posts/".$comment->post_id."/comments/".$comment->id,
            $attribute);

        $this->assertDatabaseHas('comments', $attribute);
        $response->assertRedirect("posts/".$comment->post_id);
        $this->get("/posts/".$comment->post_id)->assertSeeText($attribute['description']);
    }

    /** @test */
    public function only_authenticated_users_can_update_comment()
    {
        $comment = factory('App\Models\Comment')->create();

        $this->put("posts/".$comment->post_id."/comments/".$comment->id,
            ['description' => 'Changed description'])->assertRedirect('login');
    }

    /** @test */
    public function only_the_owner_of_the_comment_can_update_it()
    {
        $comment = factory('App\Models\Comment')->create();
        $this->be(factory('App\User')->create());

        $this->put("posts/".$comment->post_id."/comments/".$comment->id,
            ['description' => 'Changed description'])->assertStatus(403);
    }

    /** @test */
    public function user_can_delete_a_comment()
    {
        $this->be(factory('App\User')->create());
        $comment = factory('App\Models\Comment')->create();

        $response = $this->delete("posts/".$comment->post_id."/comments/".$comment->id);

        $this->assertDatabaseMissing('comments', [$comment->id]);
        $response->assertRedirect("posts/".$comment->post_id);
    }
}
