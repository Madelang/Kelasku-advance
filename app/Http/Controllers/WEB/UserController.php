<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('school')->whereDoesntHave('roles')->latest()->paginate(10);
        return view('users', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schools = School::get();
        return view('create-user', [
            'schools' => $schools
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'image' => 'required|max:2045|mimes:png,jpg,jpeg',
            'password' => 'required|min:8',
            'school_id' => 'required'
        ]);
        $input = $request->only('name', 'email', 'password', 'school_id');
        $photo = $request->file('image');
        $path = Storage::disk('public')->put('images/users', $photo);
        $input['photo'] = $path;
        $input['password'] = bcrypt($input['password']);
        User::create($input);
        return to_route('users.index')->with('success', 'Success create user!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        $schools = School::orderBy('school_name', 'asc')->get();
        return view('edit-user', [
            'user' => $user,
            'schools' => $schools
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:8',
            'image' => 'nullable|max:2045|mimes:png,jpg,jpeg',
            'school_id' => 'required'
        ]);
        $input = $request->only('name', 'email', 'password', 'school_id');
        $user = User::find($id);
        if ($request->has('image')) {
            $photo = $request->file('image');
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $path = Storage::disk('public')->put('images/users', $photo);
            $input['photo'] = $path;
        }
        if ($input['password']) {
            $input['password'] = bcrypt($input['password']);
        } else {
            unset($input['password']);
        }
        $user->update($input);
        return to_route('users.index')->with('success', 'Success updapte user!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            if ($user->photo !== null) {
                Storage::delete('public/' . $user->photo);
            }
            $user->delete();
            return to_route('users.index')->with('success', 'Success delete user!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
