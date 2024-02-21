<?php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Comment;
use Laravel\Sanctum\Sanctum;
use Illuminate\Testing\Fluent\AssertableJson;


class CommentTest extends TestCase
{
    public static User $testUser;  
    public static array $testUserData = [];

    public static function setUpBeforeClass() : void
    {
        parent::setUpBeforeClass();
       
        // Creem usuari/a de prova
        $name = "test_" . time();
        self::$testUserData = [
            "name"      => "{$name}",
            "email"     => "{$name}@mailinator.com",
            "password"  => "12345678"
        ];
    }
    public function test_post_first()
    {
       // Desem l'usuari al primer test
       self::$testUser = new User(self::$testUserData);
       self::$testUser->save();
       // Comprovem que s'ha creat
       $this->assertDatabaseHas('users', [
           'email' => self::$testUserData['email'],
       ]);
    }

    public function test_comment_create()
    {
        // Asegurarse de que el usuario esté autenticado antes de realizar la petición.
        Sanctum::actingAs(
            self::$testUser,
            ['*'] // grant all abilities to the token
        );
        $postId = 1;
        // Datos necesarios para crear una nueva reseña
        $commentData = [
            'comment' => 'This is a test comment.', // Asegúrate de que este campo coincida con la validación en el controlador
            'user_id' => self::$testUser->id, // ID del usuario autenticado
            'post_id' => 1, // ID del lugar al que se está dejando la reseña
        ];
    
        // Llamar al servicio API y revisar que no hay errores de validación.
        $response = $this->postJson("/api/posts/{$postId}/comments", $commentData);
    
        // Asegurarse de que la respuesta tenga un status 201, indicando creación exitosa.
        $response->assertStatus(201);
    
        // Validar la estructura de la respuesta y el contenido esperado.
        $response->assertJson(function ($json) use ($commentData) {
            $json->where('success', true)
                ->where('data.comment', $commentData['comment'])
                ->where('data.user_id', $commentData['user_id'])
                ->where('data.post_id', $commentData['post_id'])
                ->has('data.id');
        });
        $json = $response->getData();
        return $json->data;
    }
    public function test_comment_list()
    {
        // Actuar como el usuario de prueba autenticado
        Sanctum::actingAs(
            self::$testUser,
            ['*'] // Concede todos los permisos al token
        );

        // Listar todas las reseñas utilizando el servicio web de API
        $response = $this->getJson("/api/comments");

        // Verificar respuesta exitosa
        $response->assertOk();

        // Verificar que la respuesta contenga un array de datos
        $response->assertJsonPath("data", fn ($data) => is_array($data));
    }
    
    

   /**
    * @depends test_comment_create
    */
    public function test_comment_delete($comment)
    {
        Sanctum::actingAs(self::$testUser);
        $postId = 1;
        $commentId = $comment->id;        // Delete one file using API web service
        $response = $this->deleteJson("/api/posts/{$postId}/comments/{$comment->id}");
        
        $response->assertStatus(204);
        
        // Verificamos que la revisión haya sido eliminada de la base de datos
        $this->assertDatabaseMissing('comments', ['id' => $commentId]);
    }
}