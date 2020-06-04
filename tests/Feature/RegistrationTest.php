<?php


namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RegistrationTest extends TestCase
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
}
