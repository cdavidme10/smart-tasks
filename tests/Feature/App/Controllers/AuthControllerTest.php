<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    private const TOKEN_TYPE = 'Bearer';

    private const EXPIRATION_TIME = '60 Minutes';

    private const DEFAULT_PASSWORD = 'p1S$w0rd . ';

    private const AUTH_ROUTE = 'api/auth';

    public function test_register_with_invalid_credentials(): void
    {
        $body = [
            'email' => $this->faker->unique()->email(),
            'password' => Hash::make('password'),
        ];

        $this->postJson(self::AUTH_ROUTE.'/register', $body)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_register_with_email_already_taken(): void
    {
        $user = User::factory()->create();
        $body = [
            'email' => $user->email,
            'password' => Hash::make('password'),
        ];

        $this->postJson(self::AUTH_ROUTE.'/register', $body)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_register_with_valid_credentials(): void
    {
        $body = [
            'email' => $this->faker->unique()->email(),
            'name' => $this->faker->name(),
            'password' => self::DEFAULT_PASSWORD,
            'password_confirmation' => self::DEFAULT_PASSWORD,
        ];

        $result = $this->postJson(self::AUTH_ROUTE.'/register', $body)
            ->assertStatus(Response::HTTP_CREATED)
            ->json();

        $this->assertIsString($result['token']);
        $this->assertEquals(self::TOKEN_TYPE, $result['token_type']);
        $this->assertEquals(self::EXPIRATION_TIME, $result['expires_in']);
    }

    public function test_register_with_failed_confirmed_password(): void
    {
        $body = [
            'email' => $this->faker->unique()->email(),
            'name' => $this->faker->name(),
            'password' => self::DEFAULT_PASSWORD,
            'password_confirmation' => 'password',
        ];

        $this->postJson(self::AUTH_ROUTE.'/register', $body)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_login_with_invalid_credentials(): void
    {
        $body = [
            'email' => $this->faker->unique()->email(),
            'password' => Hash::make('password'),
        ];

        $this->postJson(self::AUTH_ROUTE.'/login', $body)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_login_with_invalid_password(): void
    {
        $user = User::factory()->create();
        $body = [
            'email' => $user->email,
            'password' => Hash::make('password'),
        ];

        $this->postJson(self::AUTH_ROUTE.'/login', $body)

            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_login_with_valid_credentials(): void
    {
        $user = User::factory()->create(['password' => Hash::make(self::DEFAULT_PASSWORD)]);
        $body = [
            'email' => $user->email,
            'password' => self::DEFAULT_PASSWORD,
        ];

        $result = $this->postJson(self::AUTH_ROUTE.'/login', $body)
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertIsString($result['token']);
        $this->assertEquals(self::TOKEN_TYPE, $result['token_type']);
        $this->assertEquals(self::EXPIRATION_TIME, $result['expires_in']);
    }

    public function test_logout_revokes_token(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson(self::AUTH_ROUTE.'/logout');

        $response->assertNoContent();
        $this->assertEmpty($user->tokens);
    }
}
