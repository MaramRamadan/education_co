<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\FilterRequest;


class UserController extends ApiController
{
     /**
     * The user service implementation.
     *
     * @var UserService
     */

    private $userService;

    /**
     * Create a new controller instance.
     *
     * @param  UserService  $userService
     * @return void
     */

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    /**
     * Display a listing of the User combine transactions.
     *
     * @return JsonResponse
     */

    public function index()
    {
        $users = $this->userService->getAllUsers();

        return $this->successResponse(['users' =>  UserResource::collection($users)],'OK');

    }

    /**
     * Filter the users based on the provided request.
     * @param filterkeys
     * @return JsonResponse
     */

    public function filter(FilterRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $filteredUsers = $this->userService->filter($validatedData);

        return $this->successResponse(['users' => UserResource::collection($filteredUsers)],'OK');
    }

}
