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
        $this->be(factory('App\User')->create());

        $attributes = factory('App\Models\Post')->raw();

        $response = $this->post('/posts', $attributes);
        $this->assertDatabaseHas('posts', $attributes);

        $response->assertRedirect('/posts');
        $this->get('/posts')->assertSee($attributes['title']);
    }

    /** @test */
    public function only_authenticated_user_can_create_a_post()
    {
        $attributes = factory('App\Models\Post')->raw();

        $response = $this->post('/posts', $attributes)->assertRedirect('login');
    }

    /** @test */
    public function post_requires_title()
    {
        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Models\Post')->raw(['title' => '']);

        $this->post('/posts', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function post_requires_a_description()
    {
        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Models\Post')->raw(['description' => '']);

        $this->post('/posts', $attributes)->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_edit_a_post()
    {
        $this->withoutExceptionHandling();

        $this->be(factory('App\User')->create());
        $post = factory('App\Models\Post')->create();

        $this->get("/posts/$post->id/edit")->assertStatus(200);

        $attributes = [
            'title'         => 'Title has Changed',
            'description'   => 'Description has changed'
        ];

        $response = $this->put("/posts/$post->id", $attributes);

        $this->assertDatabaseHas('posts', $attributes);
        $response->assertRedirect("/posts/$post->id/edit");
        $this->get('/posts')->assertSee($attributes['title']);
    }

}
