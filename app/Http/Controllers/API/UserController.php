<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Resources\FriendDetailResource;
use App\Http\Resources\FriendResource;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Traits\ResponseAPI;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends ApiController
{
    use ResponseAPI;
    private $userRepository;
    /**
     * Class constructor.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
}
