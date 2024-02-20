<?php
 
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use App\Models\Post;
use Laravel\Sanctum\Sanctum;
use Illuminate\Testing\Fluent\AssertableJson;

 
class PostTest extends TestCase
{
    public static User $testUser;   
    public static array $testUserData = [];
    public static array $validData = [];
    public static array $invalidData = [];
 
 
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

        // Create fake file
        $name  = "avatar.png";
        $size = 500; /*KB*/
        $upload = UploadedFile::fake()->image($name)->size($size);
        // TODO Omplir amb dades vàlides
        self::$validData = [
            "upload" => $upload,
            'body'        => 'Soy marc',
            'latitude'    => '8',
            'longitude'   => '12',
            'visibility_id'   => '2',
        ];
        // TODO Omplir amb dades incorrectes
        self::$invalidData = [
            "upload" => $upload,
            'body'        => 38,
            'latitude'    => '8',
            'longitude'   => '5',
            'visibility_id'   => '2',
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

    public function test_post_list()
    {
        Sanctum::actingAs(
            self::$testUser,
            ['*'] // grant all abilities to the token
        );
        // List all files using API web service
        $response = $this->getJson("/api/posts");
        // Check OK response
        $this->_test_ok($response);
        // Check JSON dynamic values
        $response->assertJsonPath("data",
            fn ($data) => is_array($data)
        );
    }

    public function test_post_create()
    {
        // Asegurarse de que el usuario esté autenticado antes de realizar la petición.
        Sanctum::actingAs(
            self::$testUser,
            ['*'] // grant all abilities to the token
        );
 
        // Llamar al servicio API y revisar que no hay errores de validación.
        $response = $this->postJson("/api/posts", self::$validData);
    
        // Asegurarse de que la respuesta tenga un status 201, indicando creación exitosa.
        $response->assertStatus(201);
    
        // Validar la estructura de la respuesta y el contenido esperado.
        // Esto incluye verificar que el 'author_id' sea el ID del usuario autenticado.
        $response->assertJson(function (AssertableJson $json) {
            $json->where('success', true)
                 ->where('data.author_id', self::$testUser->id)
                 ->where('data.body', self::$validData['body'])
                 ->where('data.latitude', self::$validData['latitude'])
                 ->where('data.longitude', self::$validData['longitude'])
                 ->where('data.visibility_id', self::$validData['visibility_id'])
                 ->has('data.id');
        });
    
        // Obtener los datos de la respuesta para usar en dependencias de otras pruebas, si es necesario.
        $postData = $response->getData()->data;
        return $postData;
    }    

    public function test_post_create_error()
    {
        Sanctum::actingAs(self::$testUser);
        // Llamar servicio API
        $response = $this->postJson("/api/posts", self::$invalidData);

        $params = [
            'body'
        ];
        $response->assertInvalid($params);
        
        // Check ERROR response
        $this->_test_error($response);
    }

    /**
     * @depends test_post_create
     */
    public function test_post_read(object $post)
    {
        // Asegurarse de que el usuario esté autenticado antes de realizar la petición.
        Sanctum::actingAs(
            self::$testUser,
            ['*'] // Otorga todas las habilidades al token.
        );

        // Intentar leer el post creado previamente.
        $response = $this->getJson("/api/posts/{$post->id}");

        // Asegurarse de que la respuesta tenga un estado 200, indicando éxito.
        $response->assertStatus(200);

        // Puedes incluir más aserciones aquí si necesitas validar contenido específico de la respuesta.
        // Por ejemplo, verificar que el cuerpo del post, el autor, etc., sean correctos.
        $response->assertJsonPath('data.id', $post->id);
    }


    public function test_post_read_notfound()
    {
        Sanctum::actingAs(self::$testUser);
        $id = "not_exists";
        $response = $this->getJson("/api/posts/{$id}");
        $this->_test_notfound($response);
    }

    /**
     * @depends test_post_create
     */

    public function test_post_update(object $post)
    {
        Sanctum::actingAs(self::$testUser);
        // Llamar servicio API y revisar que no hay errores de validacion
        $response = $this->putJson("/api/posts/{$post->id}", self::$validData);

        $params = array_keys(self::$validData);
        $response->assertValid($params);
                
        // Check OK response
        $this->_test_ok($response, 201);
    
        // Check JSON dynamic values
        $response->assertJsonPath("data.id",
            fn ($id) => !empty($id)
        );

        // Read, update and delete dependency!!!
        $json = $response->getData();
        return $json->data;
    }

    /**
     * @depends test_post_create
     */

    public function test_post_update_error(object $post)
    {
        Sanctum::actingAs(self::$testUser);
        // Llamar servicio API
        $response = $this->postJson("/api/posts", self::$invalidData);

        $params = [
            'body'
        ];
        $response->assertInvalid($params);
        // Check ERROR response
        $this->_test_error($response);
    }

    public function test_post_update_notfound()
    {
        Sanctum::actingAs(self::$testUser);
        $id = "not_exists";
        $response = $this->putJson("/api/posts/{$id}", []);
        $this->_test_notfound($response);
    }

    // MIRARLO EN DETALLE

    /**
     * @depends test_post_create
     */
    public function test_post_like(object $post)
    {
        Sanctum::actingAs(self::$testUser);
        $response = $this->postJson("/api/posts/{$post->id}/like");
        // Check OK response
        $this->_test_ok($response);
        
    }

    /**
     * @depends test_post_create
     */
    public function test_post_like_error(object $post)
    {
        Sanctum::actingAs(self::$testUser);
        $response = $this->postJson("/api/posts/{$post->id}/like");
        // Check ERROR response
        $response->assertStatus(500);
        
    }

    /**
     * @depends test_post_create
     */
    public function test_post_unlike(object $post)
    {
        Sanctum::actingAs(self::$testUser);
        // Read one file
        $response = $this->deleteJson("/api/posts/{$post->id}/like");
        // Check OK response
        $this->_test_ok($response);
        
    }

    /**
     * @depends test_post_create
     */
    public function test_post_unlike_error(object $post)
    {
        Sanctum::actingAs(self::$testUser);
        $response = $this->deleteJson("/api/posts/{$post->id}/like");
        // Check ERROR response
        $response->assertStatus(500);
        
    }

    /**
     * @depends test_post_create
     */

    public function test_post_delete(object $post)
    {
        Sanctum::actingAs(self::$testUser);
        // Delete one file using API web service
        $response = $this->deleteJson("/api/posts/{$post->id}");
        // Check OK response
        $this->_test_ok($response);
    }

    /**
     * @depends test_post_create
     */

    public function test_post_delete_notfound()
    {
        Sanctum::actingAs(self::$testUser);
        $id = "not_exists";
        $response = $this->deleteJson("/api/posts/{$id}");
        $this->_test_notfound($response);
    }

    protected function _test_ok($response, $status = 200)
    {
        // Check JSON response
        $response->assertStatus($status);
        // Check JSON properties
        $response->assertJson([
            "success" => true,
            "data"    => true // any value
        ]);
    }
    
    protected function _test_error($response)
    {
        // Check response
        $response->assertStatus(422);
        // Check JSON properties
        $response->assertJson([
            "message" => true, // any value
            "errors"  => true, // any value
        ]);       
        // Check JSON dynamic values
        $response->assertJsonPath("message",
            fn ($message) => !empty($message) && is_string($message)
        );
        $response->assertJsonPath("errors",
            fn ($errors) => is_array($errors)
        );
    }
    
    protected function _test_notfound($response)
    {
        // Check JSON response
        $response->assertStatus(404);
        // Check JSON properties
        $response->assertJson([
            "success" => false,
            "message" => true // any value
        ]);
        // Check JSON dynamic values
        $response->assertJsonPath("message",
            fn ($message) => !empty($message) && is_string($message)
        );   
    }

    public function test_post_last()
    {
       // Eliminem l'usuari al darrer test
       self::$testUser->delete();
       // Comprovem que s'ha eliminat
       $this->assertDatabaseMissing('users', [
           'email' => self::$testUserData['email'],
       ]);
    }
    
}