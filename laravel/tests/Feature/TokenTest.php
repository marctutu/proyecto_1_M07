<?php


namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Testing\Fluent\AssertableJson;


class TokenTest extends TestCase
{   
   public static object $testUser;


   public static function setUpBeforeClass() : void
   {
       parent::setUpBeforeClass();


       // Create test user (BD store later)
       $name = "test_" . time();
       self::$testUser = (object) [
           "name"      => "{$name}",
           "email"     => "{$name}@mailinator.com",
           "password"  => "12345678"
       ];
   }


   public function test_register()
   {
       // Create user using API web service
       $response = $this->postJson('/api/register', [
           "name"      => self::$testUser->name,
           "email"     => self::$testUser->email,
           "password"  => self::$testUser->password,
       ]);
       // Check response
       $response->assertOk();
       // Check validation errors
       $response->assertValid(["name"]);
       $response->assertValid(["email"]);
       $response->assertValid(["password"]);
       // Check TOKEN response
       $this->_test_token($response);
   }


   public function test_register_error()
   {
       // Create user using API web service
       $response = $this->postJson('/api/register', [
           "name"      => "",
           "email"     => "mailinator.com",
           "password"  => "12345678",
       ]);
       // Check response
       $response->assertStatus(422);
       // Check validation errors
       $response->assertInvalid(["name"]);
       $response->assertInvalid(["email"]);
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


   /**
    * @depends test_register
    */
   public function test_login()
   {
       $user = self::$testUser;
       // Login using API web service
       $response = $this->postJson('/api/login', [
           "email"     => $user->email,
           "password"  => $user->password,
       ]);
       // Check response
       $response->assertOk();
       // Check validation errors
       $response->assertValid(["email","password"]);
       // Check TOKEN response
       $this->_test_token($response);
   }


   public function test_login_invalid()
   {
       // Login using API web service
       $response = $this->postJson('/api/login', [
           "email"     => "notexists@mailinator.com",
           "password"  => "12345678",
       ]);
       // Check response
       $response->assertStatus(401);
       // Check JSON properties
       $response->assertJson([
           "success" => false,
           "message" => true, // any value
       ]);
       // Check validation errors
       $response->assertValid(["email","password"]);
   }


   /**
    * @depends test_register
    */
   public function test_logout()
   {
       $user = new User((array)self::$testUser);
       Sanctum::actingAs(
           $user,
           ['*'] // grant all abilities to the token
       );
       // Logout using API web service
       $response = $this->postJson('/api/logout');
       // Check response
       $response->assertOk();
       // Check JSON properties
       $response->assertJson([
           "success" => true,
           "message" => true, // any value
       ]);
   }


   public function test_logout_unathourized()
   {
       // Logout using API web service
       $response = $this->postJson('/api/logout');
       // Check response
       $response->assertStatus(401);
       // Check JSON properties
       $response->assertJson([
           "message" => true, // any value
       ]);
   }


   /**
    * @depends test_register
    */
   public function test_user()
   {
       $user = new User((array)self::$testUser);
       Sanctum::actingAs(
           $user,
           ['*'] // grant all abilities to the token
       );
       // Get user data using API web service
       $response = $this->getJson('/api/user');
       // Check response
       $response->assertOk();
       // Check JSON properties
       $response->assertJson([
           "success" => true,
           "user"    => true, // any value
       ]);
       $response->assertJson(
           fn (AssertableJson $json) =>
               $json->where("user.name", $user->name)
                   ->where("user.email", $user->email)
                   ->missing("user.password")
                   ->where('roles', ['author'])
                   ->etc()
       );
   }


   public function test_user_unathourized()
   {
       // Get user data using API web service
       $response = $this->getJson('/api/user');
       // Check response
       $response->assertStatus(401);
       // Check JSON properties
       $response->assertJson([
           "message" => true, // any value
       ]);
   }


   protected function _test_token($response)
   {
       // Check JSON properties
       $response->assertJson([
           "success"   => true,
           "authToken" => true, // any value
           "tokenType" => true, // any value
       ]);
       // Check JSON dynamic values
       $response->assertJsonPath("authToken",
           fn ($authToken) => !empty($authToken)
       );
       // Check JSON exact values
       $response->assertJsonPath("tokenType", "Bearer");
   }
}
