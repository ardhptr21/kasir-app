<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

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

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

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

    public function destroy(User $user)
    {
        $isDeleted = $user->delete();

        if ($isDeleted) {
            return to_route('users.index')->with('users_success', "User $user->name berhasil dihapus");
        }

        return to_route('users.index')->with('users_error', "User $user->name gagal dihapus");
    }

    public function changePassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string',
        ]);
        $validated['password'] = bcrypt($request->password);

        $updated = $user->update($validated);

        if ($updated) {
            return to_route('users.show', $user)->with('users_success', "Credential user $user->name berhasil diupdate");
        }

        return to_route('users.show', $user)->with('users_error', "Credential user $user->name gagal diupdate");
    }
}
