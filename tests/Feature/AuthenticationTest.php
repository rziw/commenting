<?php


namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\User;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function people_can_register()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $attributes = [
            'name'                  => 'rziw',
            'email'                 => 'mrs.safari20@gmail.com',
            'password'              => '123456789',
            'password_confirmation' => '123456789'
        ];

        $response = $this->post('/register', $attributes);

        $this->assertDatabaseHas('users', [
            'name'  => 'rziw',
            'email' => 'mrs.safari20@gmail.com',
        ]);

        $this->assertTrue(Auth::check());
        $response->assertRedirect('/home');

    }
    /** @test */
    function user_can_login()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        $user = factory(User::class)->create();

        $attributes = [
            'email'     => $user->email,
            'password'  => '123456789',
        ];

        $response = $this->post('/login', $attributes);

        $this->assertTrue(Auth::check());
        $response->assertRedirect('/home');
    }
}
