<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class AuthControllerTest extends TestCase
{

    public function test_login_endpoint_returns_a_500_response(): void
    {
        $body = ['email' => 'test@somebademail.com', 'password' => '1234'];
        $response = $this->json(
            'POST', 
            '/api/v1/auth/login', 
            $body,
            ['Content-Type' => 'application/json', 'Accept' => 'application/json']
        );
        $response->assertStatus(500);
        $response->assertContent('{"message":"Internal Server Error"}');
    }

    public function test_login_endpoint_returns_a_401_response(): void
    {
        Artisan::call('migrate');

        $body = ['email' => 'test@somebademail.com', 'password' => '1234'];
        $response = $this->json(
            'POST', 
            '/api/v1/auth/login', 
            $body,
            ['Content-Type' => 'application/json', 'Accept' => 'application/json']
        );
        $response->assertStatus(401);
        $response->assertContent('{"message":"Unauthorized."}');
    }

    public function test_login_endpoint_returns_a_200_response(): void
    {
        Artisan::call('passport:install', ['--no-interaction' => true]);
        Artisan::call('migrate');
        Artisan::call('db:seed UserSeeder');

        $body = ['email' => 'test@example.com', 'password' => '1234'];
        $response = $this->json(
            'POST', 
            '/api/v1/auth/login', 
            $body,
            ['Content-Type' => 'application/json', 'Accept' => 'application/json']
        );
        $content = json_decode($response->getContent());

        $response->assertStatus(200);
        $this->assertObjectHasProperty('token', $content);
        $this->assertIsString($content->token);
    }
}
