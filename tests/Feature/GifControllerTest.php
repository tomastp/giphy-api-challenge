<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class GifControllerTest extends TestCase
{

    public function test_get_gif_query_endpoint_returns_a_401_response(): void
    {
        $response = $this->json(
            'GET', 
            '/api/v1/gif', 
            ['Content-Type' => 'application/json', 'Accept' => 'application/json']
        );

        $response->assertStatus(401);
        $response->assertContent('{"message":"Unauthenticated."}');
    }

    public function test_get_gif_query_endpoint_returns_a_400_response(): void
    {
        Artisan::call('migrate');
        Artisan::call('db:seed UserSeeder');

        $user = User::where('id', 1)->get()->first();

        $this->actingAs($user, 'api');

        $response = $this->json(
            'GET', 
            '/api/v1/gif'
        );
        $response->assertStatus(400);
        $response->assertContent('{"message":"Bad Request."}');
    }

    public function test_get_gif_query_endpoint_returns_a_200_response(): void
    {
        Artisan::call('migrate');
        Artisan::call('db:seed UserSeeder');

        $user = User::where('id', 1)->get()->first();

        $this->actingAs($user, 'api');

        $response = $this->json(
            'GET', 
            '/api/v1/gif?query=cheeseburguer&limit=10&offset=0'
        );

        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

    public function test_get_gif_by_id_returns_a_200_response(): void
    {
        Artisan::call('migrate');
        Artisan::call('db:seed UserSeeder');
        Artisan::call('db:seed FavoriteGifSeeder');
        
        $user = User::where('id', 1)->get()->first();

        $this->actingAs($user, 'api');

        $response = $this->json(
            'GET', 
            '/api/v1/gif/GVaknm5baLdAc'
        );

        $response->assertStatus(200);
        $content = json_decode($response->getContent());
        $this->assertEquals($content->id, 'GVaknm5baLdAc');
        $this->assertIsString($content->url);
        $this->assertMatchesRegularExpression('/giphy.com/', $content->url);
    }

    public function test_get_gif_by_id_returns_a_404_response(): void
    {
        Artisan::call('migrate');
        Artisan::call('db:seed UserSeeder');
        
        $user = User::where('id', 1)->get()->first();

        $this->actingAs($user, 'api');

        $response = $this->json(
            'GET', 
            '/api/v1/gif/zaraza'
        );

        $response->assertStatus(404);
        $response->assertContent('{"message":"Gif ID not found."}');
    }

    public function test_get_gif_by_id_returns_a_401_response(): void
    {
        $response = $this->json(
            'GET', 
            '/api/v1/gif/zaraza', 
            ['Content-Type' => 'application/json', 'Accept' => 'application/json']
        );

        $response->assertStatus(401);
        $response->assertContent('{"message":"Unauthenticated."}');
    }
    
    public function test_post_favorite_gif_returns_a_422_response(): void
    {
        Artisan::call('migrate');
        Artisan::call('db:seed UserSeeder');
        
        $user = User::where('id', 1)->get()->first();

        $this->actingAs($user, 'api');

        $response = $this->json(
            'POST', 
            '/api/v1/gif',
            [],
            ['Content-Type' => 'application/json', 'Accept' => 'application/json']
        );
        $response->assertStatus(422);
        $response->assertContent('{"message":"The gif id field is required. (and 2 more errors)","errors":{"gif_id":["The gif id field is required."],"alias":["The alias field is required."],"user_id":["The user id field is required."]}}');
    }

    public function test_post_favorite_gif_returns_a_400_user_not_exist_response(): void
    {
        Artisan::call('migrate');
        Artisan::call('db:seed UserSeeder');
        
        $user = User::where('id', 1)->get()->first();

        $this->actingAs($user, 'api');

        $body = [
            "gif_id" => "ku5EcFe4PNGWA",
            "alias" => "test",
            "user_id" => 2
        ];
        $response = $this->json(
            'POST', 
            '/api/v1/gif',
            $body,
            ['Content-Type' => 'application/json', 'Accept' => 'application/json']
        );
        $response->assertStatus(400);
        $response->assertContent('{"message":"User does not exist."}');
    }

    public function test_post_favorite_gif_returns_a_404_gif_not_found_response(): void
    {
        Artisan::call('migrate');
        Artisan::call('db:seed UserSeeder');
        
        $user = User::where('id', 1)->get()->first();

        $this->actingAs($user, 'api');

        $body = [
            "gif_id" => "zaraza",
            "alias" => "test",
            "user_id" => 1
        ];
        $response = $this->json(
            'POST', 
            '/api/v1/gif',
            $body,
            ['Content-Type' => 'application/json', 'Accept' => 'application/json']
        );
        $response->assertStatus(404);
        $response->assertContent('{"message":"Gif ID not found."}');
    }

    public function test_post_favorite_gif_returns_a_200_response(): void
    {
        Artisan::call('migrate');
        Artisan::call('db:seed UserSeeder');
        
        $user = User::where('id', 1)->get()->first();

        $this->actingAs($user, 'api');

        $body = [
            "gif_id" => "ku5EcFe4PNGWA",
            "alias" => "test",
            "user_id" => 1
        ];
        $response = $this->json(
            'POST', 
            '/api/v1/gif',
            $body,
            ['Content-Type' => 'application/json', 'Accept' => 'application/json']
        );
        $response->assertStatus(201);
        $content = json_decode($response->getContent());
        $this->assertEquals($content->gif_id, $body['gif_id']);
        $this->assertEquals($content->alias, $body['alias']);
        $this->assertEquals($content->user_id, $body['user_id']);
    }
    
    
}
