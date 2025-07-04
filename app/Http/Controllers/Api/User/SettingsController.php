<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class SettingsController extends Controller
{
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $type = $request->query('type');

        switch ($type) {
            case 'name':
                $request->validate([
                    'name' => 'required|string|max:255',
                ]);
                $user->name = $request->input('name');
                $user->save();
                return response()->json(['success' => true, 'message' => 'Name updated successfully.']);
            case 'password':
                $request->validate([
                    'current_password' => 'required|string',
                    'password' => 'required|string|confirmed|min:8',
                ]);
                if (!Hash::check($request->input('current_password'), $user->password)) {
                    throw ValidationException::withMessages([
                        'current_password' => ['Current password is incorrect.'],
                    ]);
                }
                $user->password = Hash::make($request->input('password'));
                $user->save();
                return response()->json(['success' => true, 'message' => 'Password updated successfully.']);
            case 'avatar':
                $request->validate([
                    'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
                ]);
                $user->setAvatar($request->file('avatar'));
                return response()->json(['success' => true, 'message' => 'Avatar updated successfully.', 'avatar_url' => $user->getAvatar()]);
            default:
                return response()->json(['success' => false, 'message' => 'Invalid update type.'], 400);
        }
    }
}
