<?php


namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;


class FileTest extends TestCase
{
   public function test_file_list()
   {
       // List all files using API web service
       $response = $this->getJson("/api/files");
       // Check OK response
       $this->_test_ok($response);
   }


   public function test_file_create() : object
   {
       // Create fake file
       $name  = "avatar.png";
       $size = 500; /*KB*/
       $upload = UploadedFile::fake()->image($name)->size($size);
       // Upload fake file using API web service
       $response = $this->postJson("/api/files", [
           "upload" => $upload,
       ]);
       // Check OK response
       $this->_test_ok($response, 201);
       // Check validation errors
       $response->assertValid(["upload"]);
       // Check JSON exact values
       $response->assertJsonPath("data.filesize", $size*1024);
       // Check JSON dynamic values
       $response->assertJsonPath("data.id",
           fn ($id) => !empty($id)
       );
       $response->assertJsonPath("data.filepath",
           fn ($filepath) => str_contains($filepath, $name)
       );
       // Read, update and delete dependency!!!
       $json = $response->getData();
       return $json->data;
   }


   public function test_file_create_error()
   {
       // Create fake file with invalid max size
       $name  = "avatar.png";
       $size = 5000; /*KB*/
       $upload = UploadedFile::fake()->image($name)->size($size);
       // Upload fake file using API web service
       $response = $this->postJson("/api/files", [
           "upload" => $upload,
       ]);
       // Check ERROR response
       $this->_test_error($response);
   }


   /**
    * @depends test_file_create
    */
   public function test_file_read(object $file)
   {
       // Read one file
       $response = $this->getJson("/api/files/{$file->id}");
       // Check OK response
       $this->_test_ok($response);
       // Check JSON exact values
       $response->assertJsonPath("data.filepath",
           fn ($filepath) => !empty($filepath)
       );
   }
  
   public function test_file_read_notfound()
   {
       $id = "not_exists";
       $response = $this->getJson("/api/files/{$id}");
       $this->_test_notfound($response);
   }


   /**
    * @depends test_file_create
    */
   public function test_file_update(object $file)
   {
       // Create fake file
       $name  = "photo.jpg";
       $size = 1000; /*KB*/
       $upload = UploadedFile::fake()->image($name)->size($size);
       // Upload fake file using API web service
       $response = $this->putJson("/api/files/{$file->id}", [
           "upload" => $upload,
       ]);
       // Check OK response
       $this->_test_ok($response);
       // Check validation errors
       $response->assertValid(["upload"]);
       // Check JSON exact values
       $response->assertJsonPath("data.filesize", $size*1024);
       // Check JSON dynamic values
       $response->assertJsonPath("data.filepath",
           fn ($filepath) => str_contains($filepath, $name)
       );
   }


   /**
    * @depends test_file_create
    */
   public function test_file_update_error(object $file)
   {
       // Create fake file with invalid max size
       $name  = "photo.jpg";
       $size = 3000; /*KB*/
       $upload = UploadedFile::fake()->image($name)->size($size);
       // Upload fake file using API web service
       $response = $this->putJson("/api/files/{$file->id}", [
           "upload" => $upload,
       ]);
       // Check ERROR response
       $this->_test_error($response);
   }


   public function test_file_update_notfound()
   {
       $id = "not_exists";
       $response = $this->putJson("/api/files/{$id}", []);
       $this->_test_notfound($response);
   }


   /**
    * @depends test_file_create
    */
   public function test_file_delete(object $file)
   {
       // Delete one file using API web service
       $response = $this->deleteJson("/api/files/{$file->id}");
       // Check OK response
       $this->_test_ok($response);
   }


   public function test_file_delete_notfound()
   {
       $id = "not_exists";
       $response = $this->deleteJson("/api/files/{$id}");
       $this->_test_notfound($response);
   }


   protected function _test_ok($response, $status = 200)
   {
       // Check JSON response
       $response->assertStatus($status);
       // Check JSON properties
       $response->assertJson([
           "success" => true,
       ]);
       // Check JSON dynamic values
       $response->assertJsonPath("data",
           fn ($data) => is_array($data)
       );
   }


   protected function _test_error($response)
   {
       // Check response
       $response->assertStatus(422);
       // Check validation errors
       $response->assertInvalid(["upload"]);
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
}
