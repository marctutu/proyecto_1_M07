<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\File;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_post()
    {
        $user = User::factory()->create();
        $file = File::factory()->create(); // Asegúrate de tener una Factory para el modelo File
    
        $response = $this->actingAs($user, 'sanctum')->postJson('/api/posts', [
            'body' => 'Test body',
            'latitude' => '123.123',
            'longitude' => '456.456',
            'visibility_id' => 1,
            'file_id' => $file->id, // Asociar el archivo creado a este post
        ]);
    
        $response->assertStatus(201);
    }    

    public function test_read_post()
    {
        $post = Post::factory()->create();

        $response = $this->getJson('/api/posts/' . $post->id);

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $post->id,
                     'body' => $post->body,
                     // otros campos que quieras verificar
                 ]);
    }

    public function test_update_post()
    {
        $post = Post::factory()->create();
        $user = User::find($post->author_id);

        $response = $this->actingAs($user, 'sanctum')->putJson('/api/posts/' . $post->id, [
            'body' => 'Updated body',
            // otros campos que quieras actualizar
        ]);

        $response->assertStatus(200);
    }

    public function test_delete_post()
    {
        $post = Post::factory()->create();
        $user = User::find($post->author_id);

        $response = $this->actingAs($user, 'sanctum')->deleteJson('/api/posts/' . $post->id);

        $response->assertStatus(204);
    }
}
