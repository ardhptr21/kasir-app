<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:255',
            'nik' => 'required|numeric|digits:16',
            'role' => 'required|string',
            'password' => 'required|string',
        ]);
        $validated['password'] = bcrypt($request->password);

        $user = User::create($validated);

        if ($user) {
            return to_route('users.index')->with('users_success', "User $user->name berhasil ditambahkan");
        }

        return to_route('users.index')->with('users_error', "User {$validated['name']} gagal ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:255',
            'nik' => 'required|numeric|digits:16',
            'role' => 'required|string',
        ]);

        $updated = $user->update($validated);

        if ($updated) {
            return to_route('users.show', $user)->with('users_success', "User $user->name berhasil diupdate");
        }

        return to_route('users.show', $user)->with('users_error', "User $user->name gagal diupdate");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $isDeleted = $user->delete();

        if ($isDeleted) {
            return to_route('users.index')->with('users_success', "User $user->name berhasil dihapus");
        }

        return to_route('users.index')->with('users_error', "User $user->name gagal dihapus");
    }
}
