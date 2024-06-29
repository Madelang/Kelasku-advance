<?php

namespace App\Repositories;

use App\Models\Like;
use App\Models\User;

interface interfaceLikeRepository
{
    public function toggleLike($id, $createdBy);
}
class LikeRepository implements interfaceLikeRepository
{
    public function toggleLike($id, $createdBy)
    {
        $user = User::find($id);
        if (!$user) {
            throw new \Exception('User not found');
        }

        $like = Like::where('like_user_id', $id)
            ->where('user_id', $createdBy)
            ->first();

        if ($like) {
            $user->decrement('total_likes');
            $like->delete();
            return false;
        } else {
            $user->increment('total_likes');
            Like::create([
                'like_user_id' => $id,
                'user_id' => $createdBy
            ]);
            return true;
        }
    }

    /**
     * Get like history user likes by another users get who like this user by id
     */
    public function getLikesUserById($id)
    {
        $rawData = Like::where('like_user_id', $id)->orderBy('created_at', 'DESC')->get();
        return $rawData;
    }
}
