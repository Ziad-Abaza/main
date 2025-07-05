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
            'bio' => 'nullable|string|max:2000',
            'specialization' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'website_url' => 'nullable|url|max:255',
            'skills' => 'nullable|array',
            'skills.*' => 'nullable|string|max:100',
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

        // Update instructor profile fields if profile exists
        $profile = $user->instructorProfile;
        if ($profile) {
            // Handle skills as comma-separated string from form
            $skillsInput = $request->skills;
            if (is_string($skillsInput)) {
                $skillsArray = array_filter(array_map('trim', explode(',', $skillsInput)));
            } elseif (is_array($skillsInput)) {
                $skillsArray = $skillsInput;
            } else {
                $skillsArray = [];
            }
            $profile->update([
                'bio' => $request->bio,
                'specialization' => $request->specialization,
                'experience' => $request->experience,
                'linkedin_url' => $request->linkedin_url,
                'github_url' => $request->github_url,
                'website_url' => $request->website_url,
                'skills' => json_encode($skillsArray),
            ]);
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
    }
}
