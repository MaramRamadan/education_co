<?php
namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Http\Controllers\UserController;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mockery;

class UserControllerTest extends TestCase
{
    public function testIndexReturnsUsers()
    {

        $userServiceMock =Mockery::mock(UserService::class, function ($mock){
            $mock->shouldReceive("getAllUsers")->andReturn([]);
        });

        // Create an instance of the UserController and inject the mocked UserService
        $userController = new UserController($userServiceMock);

        // Make a request to the index method
        $response = $userController->index();

        // Assert that the response is successful
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        // Assert that the response contains the expected JSON structure
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('users', $responseData['data']);
        $this->assertIsArray($responseData['data']['users']);
    }

    public function testFilterReturnsFilteredUsers()
    {
        // Prepare mock request data
        $requestData = [
            'status' => 'authorized,refunded',
            'currency' => 'usd',
        ];

        $userServiceMock =Mockery::mock(UserService::class, function ($mock){
            $mock->shouldReceive("filter")->andReturn([]);
        });

        // Create an instance of the UserController and inject the mocked UserService
        $userController = new UserController($userServiceMock);

        // Create a mock Request object with the request data
        $request = Request::create('/filter', 'GET', $requestData);

        // Make a request to the filter method
        $response = $userController->filter($request);

        // Assert that the response is successful
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        // Assert that the response contains the expected JSON structure
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('users', $responseData['data']);
        $this->assertIsArray($responseData['data']['users']);
    }

}
