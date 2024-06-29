<?php

namespace App\Repositories;

use App\Models\User;
use Error;


interface interfaceUserRepository
{
    public function register($data);
    public function update($data, $idUser);
    public function logout($idUser);
    public function deleteUser($id);
    public function getFriends();
    public function getOneFriend($id);
    public function getUserPaginate($role, $limit = 10);
    public function getOne($id);
}



class UserRepository implements interfaceUserRepository
{
    public function register($data)
    {
        try {
            return User::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function update($data, $idUser)
    {
        try {
            User::findOrFail($idUser)->update($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getFriends()
    {
        try {
            return User::where('id', '!=', auth('api')->id())->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getOneFriend($id)
    {
        try {
            $user = User::findOrFail($id);
            return $user;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    /**
     * get User by role admin or user
     */
    public function getUserPaginate($role, $limit = 10)
    {
        if ($role === 'admin') {
            return User::with('school')->orderBy('created_at', 'DESC')->where('id', '!=', auth()->id())->where('role_id', 1)->paginate($limit);
        } elseif ($role === 'user') {
            return User::orderBy('created_at', 'DESC')->with('school')->where('role_id', 2)->where('id', '!=', auth()->id())->paginate($limit);
        } else {
            return;
        }
    }
    public function getOne($id)
    {
        try {
            $user = User::findOrFail($id);
            return $user;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            throw new \Exception('User not found');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            throw new Error('User not found', 404);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function logout($id)
    {
        try {
            User::find($id)->update([
                "device_token" => null
            ]);
            return;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
