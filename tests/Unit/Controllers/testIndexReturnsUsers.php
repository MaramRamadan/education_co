<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Http\Controllers\UserController;
use App\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mockery;

class testIndexReturnsUsers extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function testIndexReturnsUsers()
    {
        // Mock the UserService

        $users = [
            // Mock or create sample user objects
        ];

        

        // Create an instance of the UserController and inject the mocked UserService
        $userController = new UserController($userServiceMock);

        // Make a request to the index method
        $response = $userController->index();

        // Assert that the response is successful
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        // Assert that the response contains the expected JSON structure
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        // dd($responseData);
        $this->assertArrayHasKey('users', $responseData['data']);
        $this->assertIsArray($responseData['data']['users']);
    }

}
