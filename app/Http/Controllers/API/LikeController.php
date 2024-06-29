<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Requests\API\UserIdRequest;
use App\Http\Resources\LikeHistoryResource;
use App\Models\Like;
use App\Models\User;
use App\Services\LikeService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LikeController extends ApiController
{

    private $likeService;
    /**
     * Class constructor.
     */
    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }
    public function store(UserIdRequest $userIdRequest)
    {
        try {
            $idTargetLike = $userIdRequest->input('user_id');
            if ($idTargetLike == $this->guard()->id()) {
                return $this->badRequest('Failed! cannot like yourself', 'bad_request');
            }
            $log = $this->likeService->giveLike($idTargetLike, $this->guard()->id());
            return $this->requestSuccessData($log);
        } catch (ModelNotFoundException $e) {
            return $this->requestNotFound('User not found!');
        } catch (\Throwable $e) {
            return $this->badRequest('Failed!', $e->getMessage());
        }
    }
    public function show()
    {
        try {
            $likes = $this->likeService->getLikes($this->guard()->id());
            return $this->requestSuccessData($likes);
        } catch (\Throwable $th) {
            $this->badRequest('Failed!', $th->getMessage());
        }
    }
}
