<?php
namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use App\Models\Place;
use Laravel\Sanctum\Sanctum;
use Illuminate\Testing\Fluent\AssertableJson;


class PlaceTest extends TestCase
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
           'name'   => 'axel',
           'description'        => 'Soy axel',
           'latitude'    => '8',
           'longitude'   => '12',
           'visibility_id'   => '2',
       ];
       // TODO Omplir amb dades incorrectes
       self::$invalidData = [
           "upload" => $upload,
           'name'   => 7,
           'description'        => 38,
           'latitude'    => '8',
           'longitude'   => '5',
           'visibility_id'   => '2',
       ];
   }
   public function test_place_first()
   {
      // Desem l'usuari al primer test
      self::$testUser = new User(self::$testUserData);
      self::$testUser->save();
      // Comprovem que s'ha creat
      $this->assertDatabaseHas('users', [
          'email' => self::$testUserData['email'],
      ]);
   }


   public function test_place_list()
   {
       Sanctum::actingAs(
           self::$testUser,
           ['*'] // grant all abilities to the token
       );
       // List all files using API web service
       $response = $this->getJson("/api/places");
       // Check OK response
       $this->_test_ok($response);
       // Check JSON dynamic values
       $response->assertJsonPath("data",
           fn ($data) => is_array($data)
       );
   }


   public function test_place_create()
   {
       // Asegurarse de que el usuario esté autenticado antes de realizar la petición.
       Sanctum::actingAs(
           self::$testUser,
           ['*'] // grant all abilities to the token
       );
       // Llamar al servicio API y revisar que no hay errores de validación.
       $response = $this->postJson("/api/places", self::$validData);
  
       // Asegurarse de que la respuesta tenga un status 201, indicando creación exitosa.
       $response->assertStatus(201);
  
       // Validar la estructura de la respuesta y el contenido esperado.
       // Esto incluye verificar que el 'author_id' sea el ID del usuario autenticado.
       $response->assertJson(function (AssertableJson $json) {
           $json->where('success', true)
                ->where('data.author_id', self::$testUser->id)
                ->where('data.description', self::$validData['description'])
                ->where('data.latitude', self::$validData['latitude'])
                ->where('data.longitude', self::$validData['longitude'])
                ->where('data.visibility_id', self::$validData['visibility_id'])
                ->has('data.id');
       });
  
       // Obtener los datos de la respuesta para usar en dependencias de otras pruebas, si es necesario.
       $placeData = $response->getData()->data;
       return $placeData;
   }   


   public function test_place_create_error()
   {
       Sanctum::actingAs(self::$testUser);
       // Llamar servicio API
       $response = $this->postJson("/api/places", self::$invalidData);


       $params = [
           'description'
       ];
       $response->assertInvalid($params);
      
       // Check ERROR response
       $this->_test_error($response);
   }


   /**
    * @depends test_place_create
    */
   public function test_place_read(object $place)
   {
       // Asegurarse de que el usuario esté autenticado antes de realizar la petición.
       Sanctum::actingAs(
           self::$testUser,
           ['*'] // Otorga todas las habilidades al token.
       );


       // Intentar leer el place creado previamente.
       $response = $this->getJson("/api/places/{$place->id}");


       // Asegurarse de que la respuesta tenga un estado 200, indicando éxito.
       $response->assertStatus(200);


       // Puedes incluir más aserciones aquí si necesitas validar contenido específico de la respuesta.
       // Por ejemplo, verificar que el cuerpo del place, el autor, etc., sean correctos.
       $response->assertJsonPath('data.id', $place->id);
   }




   public function test_place_read_notfound()
   {
       Sanctum::actingAs(self::$testUser);
       $id = "not_exists";
       $response = $this->getJson("/api/places/{$id}");
       $this->_test_notfound($response);
   }


   /**
    * @depends test_place_create
    */


   public function test_place_update(object $place)
   {
       Sanctum::actingAs(self::$testUser);
       // Llamar servicio API y revisar que no hay errores de validacion
       $response = $this->putJson("/api/places/{$place->id}", self::$validData);


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
    * @depends test_place_create
    */


   public function test_place_update_error(object $place)
   {
       Sanctum::actingAs(self::$testUser);
       // Llamar servicio API
       $response = $this->postJson("/api/places", self::$invalidData);


       $params = [
           'description'
       ];
       $response->assertInvalid($params);
       // Check ERROR response
       $this->_test_error($response);
   }


   public function test_place_update_notfound()
   {
       Sanctum::actingAs(self::$testUser);
       $id = "not_exists";
       $response = $this->putJson("/api/places/{$id}", []);
       $this->_test_notfound($response);
   }


   // MIRARLO EN DETALLE


   /**
    * @depends test_place_create
    */
   public function test_place_favorite(object $place)
   {
       Sanctum::actingAs(self::$testUser);
       $response = $this->postJson("/api/places/{$place->id}/favorite");
       // Check OK response
       $this->_test_ok($response);
      
   }


   /**
    * @depends test_place_create
    */
   public function test_place_favorite_error(object $place)
   {
       Sanctum::actingAs(self::$testUser);
       $response = $this->postJson("/api/places/{$place->id}/favorite");
       // Check ERROR response
       $response->assertStatus(500);
      
   }


   /**
    * @depends test_place_create
    */
   public function test_place_unfavorite(object $place)
   {
       Sanctum::actingAs(self::$testUser);
       // Read one file
       $response = $this->deleteJson("/api/places/{$place->id}/favorite");
       // Check OK response
       $this->_test_ok($response);
      
   }


   /**
    * @depends test_place_create
    */
   public function test_place_unfavorite_error(object $place)
   {
       Sanctum::actingAs(self::$testUser);
       $response = $this->deleteJson("/api/places/{$place->id}/favorite");
       // Check ERROR response
       $response->assertStatus(500);
      
   }


   /**
    * @depends test_place_create
    */


   public function test_place_delete(object $place)
   {
       Sanctum::actingAs(self::$testUser);
       // Delete one file using API web service
       $response = $this->deleteJson("/api/places/{$place->id}");
       // Check OK response
       $this->_test_ok($response);
   }


   /**
    * @depends test_place_create
    */


   public function test_place_delete_notfound()
   {
       Sanctum::actingAs(self::$testUser);
       $id = "not_exists";
       $response = $this->deleteJson("/api/places/{$id}");
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


   public function test_place_last()
   {
      // Eliminem l'usuari al darrer test
      self::$testUser->delete();
      // Comprovem que s'ha eliminat
      $this->assertDatabaseMissing('users', [
          'email' => self::$testUserData['email'],
      ]);
   }
  
}
