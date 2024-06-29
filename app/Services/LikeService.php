<?php

namespace App\Services;

use App\Helpers\FCM;
use App\Http\Resources\LikeHistoryResource;
use App\Models\Like;
use App\Models\NotificationHistory;
use App\Models\User;
use Illuminate\Support\Str;
use App\Repositories\LikeRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface interfaceLikeService
{
    public function giveLike($id);
}
class LikeService
{
    private $likeRepository;
    /**
     * Class constructor.
     */
    public function __construct(LikeRepository $likeRepository)
    {
        $this->likeRepository = $likeRepository;
    }
    public function giveLike($id, $created_by)
    {
        try {
            $senderFirstName = substr(auth('api')->user()->name, 0, strpos(auth('api')->user()->name, " "));
            $tittle = $senderFirstName . ' like your account';
            $user = User::findOrFail($id);
            $message = 'Give it feedback to ' . Str::lower($senderFirstName);
            $device_token = [$user->device_token];
            if ($this->likeRepository->toggleLike($id, $created_by)) {
                $countHistoryNotification = NotificationHistory::where('to', $id)->where('user_id', $created_by)->where('type', 'like')->count();
                if ($countHistoryNotification < 1) {
                    NotificationHistory::create([
                        "type" => 'like',
                        "to" => $user->id,
                        "user_id" => $created_by,
                        "sent_at" => Carbon::now(),
                    ]);
                    // $fcmLog = FCM::to($device_token)->send([
                    //     'title' => $tittle,
                    //     'user_id' => $user->id,
                    //     'message' => $message,
                    //     'user_id' => auth('api')->id()
                    // ]);
                    return [
                        "status_like" => "like",
                    ];
                } else {
                    return [
                        "status_like" => "like",
                        "log_notification" => null
                    ];
                }
            } else {
                return [
                    "status_like" => "unlike",
                    "log_notification" => null
                ];
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Get likes by id
     */
    public function getLikes($id)
    {
        try {
            $rawData = $this->likeRepository->getLikesUserById($id);
            $likes = LikeHistoryResource::collection($rawData);
            return $likes;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
