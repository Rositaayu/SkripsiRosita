<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('pages.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id_user);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
        ]);

        if ($request->email != $user->email) {
            $validator->sometimes('email', 'unique:users,email', function ($input) use ($user) {
                return $input->email != $user->email;
            });
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }

    public function password()
    {
        return view('pages.profile.password');
    }

    public function updatePassword(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id_user);

        $validator = Validator::make($request->all(), [
            'old_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'password' => ['required', 'confirmed', 'min:8', 'different:old_password']
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('profile.password')->with('success', 'Password updated successfully.');
    }
}
