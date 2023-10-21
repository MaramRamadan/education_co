<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Http\Controllers\UserController;
use App\Services\UserService;
use App\Http\Requests\FilterRequest;
use Mockery;
use Illuminate\Http\JsonResponse;


class testFilterReturnsFilteredUsers extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function testFilterReturnsFilteredUsers()
    {
       // Arrange
       $validatedData = [
            'status' => 'declines'
        ];


        $filteredUsers = [
            (object)[
                'user_id' => '3fc2-a8d1',
                'balance' => 354.5,
                'currency' => 'SAR',
                'email' => 'parent1@parent.eu',
                'created' => '22/12/2018',
                'transactions' => [
                    (object)[
                        'paid_amount' => 150,
                        'currency' => 'SAR',
                        'parent_email' => 'parent1@parent.eu',
                        'status_code' => 2,
                        'payment_date' => '2021-10-6',
                        'parent_identification' => 'd3d29d70-1d66-11e3-8591-034165a3a613'
                    ]
                ]
            ],
            (object)[
                'user_id' => '4fc2-a8d1',
                'balance' => 1000,
                'currency' => 'USD',
                'email' => 'parent2@parent.eu',
                'created' => '22/12/2018',
                'transactions' => [
                    (object)[
                        'paid_amount' => 200.5,
                        'currency' => 'USD',
                        'parent_email' => 'parent2@parent.eu',
                        'status_code' => 2,
                        'payment_date' => '2018-01-01',
                        'parent_identification' => 'e3rffr-1d25-dddw-8591-034165a3a613'
                    ]
                ]
            ],
            (object)[
                'user_id' => '4ff3-a8d9',
                'balance' => 900,
                'currency' => 'SAR',
                'email' => 'parent6@parent.eu',
                'created' => '02/08/2020',
                'transactions' => [
                    (object)[
                        'paid_amount' => 700,
                        'currency' => 'SAR',
                        'parent_email' => 'parent6@parent.eu',
                        'status_code' => 2,
                        'payment_date' => '2021-11-30',
                        'parent_identification' => 't3d29d70-1d25-11e3-8591-034166a3a613'
                    ]
                ]
            ],
            (object)[
                'user_id' => '9fr3-a8d9',
                'balance' => 600,
                'currency' => 'SAR',
                'email' => 'parent7@parent.eu',
                'created' => '04/09/2019',
                'transactions' => [
                    (object)[
                        'paid_amount' => 700,
                        'currency' => 'SAR',
                        'parent_email' => 'parent7@parent.eu',
                        'status_code' => 2,
                        'payment_date' => '2021-11-30',
                        'parent_identification' => 't3d29d70-1d25-11e3-8591-034166a3a613'
                    ],
                    (object)[
                        'paid_amount' => 200,
                        'currency' => 'SAR',
                        'parent_email' => 'parent7@parent.eu',
                        'status_code' => 2,
                        'payment_date' => '2020-11-30',
                        'parent_identification' => 'bf533db0-f866-4aa2-9c00-55584f63419c'
                    ]
                ]
            ]
        ];

        $expectedFilteredUsers = [
            [
                'id' => '3fc2-a8d1',
                'balance' => 354.5,
                'currency' => 'SAR',
                'email' => 'parent1@parent.eu',
                'created_at' => '22/12/2018',
                'transactions' => [
                    [
                        'paid_amount' => 150,
                        'currency' => 'SAR',
                        'parent_email' => 'parent1@parent.eu',
                        'status_code' => 2,
                        'payment_date' => '2021-10-6',
                        'parent_identification' => 'd3d29d70-1d66-11e3-8591-034165a3a613'
                    ]
                ]
            ],
            [
                'id' => '4fc2-a8d1',
                'balance' => 1000,
                'currency' => 'USD',
                'email' => 'parent2@parent.eu',
                'created_at' => '22/12/2018',
                'transactions' => [
                    [
                        'paid_amount' => 200.5,
                        'currency' => 'USD',
                        'parent_email' => 'parent2@parent.eu',
                        'status_code' => 2,
                        'payment_date' => '2018-01-01',
                        'parent_identification' => 'e3rffr-1d25-dddw-8591-034165a3a613'
                    ]
                ]
            ],
            [
                'id' => '4ff3-a8d9',
                'balance' => 900,
                'currency' => 'SAR',
                'email' => 'parent6@parent.eu',
                'created_at' => '02/08/2020',
                'transactions' => [
                    [
                        'paid_amount' => 700,
                        'currency' => 'SAR',
                        'parent_email' => 'parent6@parent.eu',
                        'status_code' => 2,
                        'payment_date' => '2021-11-30',
                        'parent_identification' => 't3d29d70-1d25-11e3-8591-034166a3a613'
                    ]
                ]
            ],
            [
                'id' => '9fr3-a8d9',
                'balance' => 600,
                'currency' => 'SAR',
                'email' => 'parent7@parent.eu',
                'created_at' => '04/09/2019',
                'transactions' => [
                    [
                        'paid_amount' => 700,
                        'currency' => 'SAR',
                        'parent_email' => 'parent7@parent.eu',
                        'status_code' => 2,
                        'payment_date' => '2021-11-30',
                        'parent_identification' => 't3d29d70-1d25-11e3-8591-034166a3a613'
                    ],
                    [
                        'paid_amount' => 200,
                        'currency' => 'SAR',
                        'parent_email' => 'parent7@parent.eu',
                        'status_code' => 2,
                        'payment_date' => '2020-11-30',
                        'parent_identification' => 'bf533db0-f866-4aa2-9c00-55584f63419c'
                    ]
                ]
            ]
        ];

        $userServiceMock =Mockery::mock(UserService::class, function ($mock) use($filteredUsers){
            // $mock->set('userService', $userServiceMock);
            $mock->shouldReceive("filter")->once()->andReturn($filteredUsers);
        });

        $controller = new UserController($userServiceMock);

        $request =Mockery::mock(FilterRequest::class, function ($mock) use($validatedData){
            // $mock->set('userService', $userServiceMock);
            $mock->shouldReceive("validated")->once()->andReturn($validatedData);
        });

        // Act
        $response = $controller->filter($request);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertJson($response->getContent());

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals('Success', $responseData['status']);
        $this->assertEquals('OK', $responseData['message']);
        $this->assertArrayHasKey('data', $responseData);
        $this->assertArrayHasKey('users', $responseData['data']);
        $this->assertEquals($expectedFilteredUsers, $responseData['data']['users']);
    }
}
