<?php

namespace App\Http\Controllers\API;

use App\Helpers\FCM;
use App\Http\Controllers\ApiController;
use App\Http\Requests\API\ColekRequest;
use App\Http\Requests\API\UserIdRequest;
use App\Models\NotificationHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NotificationController extends ApiController
{

    public function colek(UserIdRequest $userIdRequest)
    {
        try {
            $maximalColekInOneDay = 10;
            $id = $userIdRequest->input('user_id');
            $find = User::findOrFail($id);
            $check = NotificationHistory::where('user_id', $this->guard()->id())->where('to', $find->id)->whereDate('sent_at', today())->where('type', 'colek')->count();
            if ($check >= $maximalColekInOneDay) {
                return $this->badRequest('limit_request', "Failed!, You allready colek " . $find->name . 'today');
            }
            $checkMax = NotificationHistory::where('user_id', $this->guard()->id())->whereDate('sent_at', today())->where('type', 'colek')->count();
            if ($checkMax >= $maximalColekInOneDay) {
                return $this->badRequest('limit_request', "Failed!, maximal send " . $maximalColekInOneDay . " colek in 1 day");
            }
            $device_token = [$find->device_token];
            $tittle = $this->guard()->user()->name . ' telah mencolek anda';
            $message = 'Halo ' . $find->name . ' ada yang nyapa kamu nih ..';
            FCM::to($device_token)->send([
                'title' => $tittle,
                'message' => $message,
                'user_id' => $this->guard()->id(),
            ]);
            NotificationHistory::create([
                "type" => 'colek',
                "to" => $find->id,
                "user_id" => $this->guard()->id(),
                "sent_at" => Carbon::now(),
            ]);
            return $this->requestSuccess('Success!');
        } catch (ModelNotFoundException $th) {
            return $this->requestNotFound('User not found!');
        } catch (\Throwable $th) {
            return $this->badRequest('Failed!', $th->getMessage());
        }
    }
    public function sendNotificationDevelopment(Request $request)
    {
        try {
            $data = $request->only('title', 'message');
            $to = $request->only('to');
            $logFCM = FCM::to($to)->send($data);
            if ($logFCM['success'] === 1) {
                return $this->requestSuccessWithLog($logFCM);
            } else {
                return $this->badRequestWithLog($logFCM);
            }
        } catch (\Throwable $th) {
            return $this->badRequestWithLog($th);
        }
    }
}
