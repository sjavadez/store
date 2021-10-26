<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /** @test */
    function login_successful()
    {
        $user = User::factory()->create();

        $data = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $result = $this->post('api/v1/login', $data)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'name',
                    'email',
                    'role',
                    'token'
                ]
            ]);

        return $result->json();
    }

    /** @test */
    function login_with_validation_error()
    {
        $user = User::factory()->create();

        $data1 = [
            'password' => 'password'
        ];

        $data2 = [
            'email' => $user->email,
        ];

        $this->post('api/v1/login', $data1,['accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['email']);

        $this->post('api/v1/login', $data2, ['accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['password']);

    }

    /** @test */
    function login_bad_credential_error()
    {
        $user = User::factory()->create();

        $data = [
            'email' => $user->email,
            'password' => 'wrongPass',
        ];

        $this->post('api/v1/login', $data ,['accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertSimilarJson([
                'data' => [
                    'message' => 'Bad Credential',
                    'result' => false
                ]
            ]);

    }

    /** @test */
    function logout_successful()
    {
        $loginResponse = $this->login_successful();

        $token = 'Bearer ' . $loginResponse['data']['token'];

        $this->delete('api/v1/logout',[], ['accept' => 'application/json', 'Authorization' => $token])
            ->dump()
            ->assertStatus(Response::HTTP_OK)
            ->assertSimilarJson([
                'data' => [
                    'message' => 'Logged out',
                    'result' => true
                ],
            ]);

        $this->delete('api/v1/logout',[], ['accept' => 'application/json', 'Authorization' => $token])
            ->dump()
            ->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertSimilarJson(['message' => 'Unauthenticated.']);
    }

    /** @test */
    function logout_use_invalid_token()
    {
        $loginResponse = $this->login_successful();

        $token = 'Bearer invalid';

        $this->delete('api/v1/logout',[], ['accept' => 'application/json', 'Authorization' => $token])
            ->dump()
            ->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertSimilarJson(['message' => 'Unauthenticated.']);
    }
}
