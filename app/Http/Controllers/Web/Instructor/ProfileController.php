<?php

namespace App\Http\Controllers\Web\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('instructor.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('instructor.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        /**
         * @var \App\Models\User $user
         */
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->hasFile('avatar')) {
            $user->setAvatar($request->file('avatar'));
        }

        return redirect()->route('dashboard.profile.index')->with('success', 'Profile updated successfully.');
    }
    public function changePassword()
    {
        return view('instructor.profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        /**
         * @var \App\Models\User $user
         */
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('dashboard.profile.index')->with('success', 'Password updated successfully.');

    }}
