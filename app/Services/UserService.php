<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;

class UserService  
{
    protected $userRepo;

    public function __construct (UserRepository $userRepo) {

        $this->userRepo = $userRepo;
    }


    public function getAllUsers(){
        
        return $this->userRepo->getAllUsers();
    }


    public function filter($request){
        
        return $this->userRepo->filter($request);
    }

}
 