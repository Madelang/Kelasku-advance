<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\ApiController;
use App\Http\Resources\FriendDetailResource;
use App\Http\Resources\FriendResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FriendController extends ApiController
{
    private $userRepository;
    /**
     * Class constructor.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function index()
    {
        $rawData = User::where('id', '!=', $this->guard()->id())->orderBy('created_at', 'DESC')->get();
        $data = FriendResource::collection($rawData);
        return $this->requestSuccessData($data);
    }
    public function show($id)
    {
        try {
            $rawData = $this->userRepository->getOneFriend($id);
            $data = new FriendDetailResource($rawData);
            return $this->requestSuccessData($data);
        } catch (ModelNotFoundException $th) {
            return $this->requestNotFound('User not found!');
        } catch (\Exception $th) {
            return $this->badRequest('Failed!', 'something_wrong');
        }
    }
}
