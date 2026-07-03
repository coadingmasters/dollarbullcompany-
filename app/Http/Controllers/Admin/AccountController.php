<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    /**
     * Show the admin account / password form.
     */
    public function edit()
    {
        $admin = auth('admin')->user();

        return view('admin.account.edit', compact('admin'));
    }

    /**
     * Update the admin's profile and/or password.
     */
    public function update(Request $request)
    {
        $admin = auth('admin')->user();

        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['required', 'email', 'max:255', Rule::unique('admins', 'email')->ignore($admin->id)],
            'current_password' => ['required', 'current_password:admin'],
            'password'         => ['nullable', 'confirmed', 'min:8'],
        ], [
            'current_password.required'         => 'Please enter your current password to save changes.',
            'current_password.current_password' => 'Your current password is incorrect.',
            'password.confirmed'                => 'The new password and its confirmation do not match.',
            'password.min'                      => 'The new password must be at least 8 characters.',
        ]);

        $admin->name  = $validated['name'];
        $admin->email = $validated['email'];

        $passwordChanged = false;
        if (! empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
            $passwordChanged = true;
        }

        $admin->save();

        return redirect()
            ->route('admin.account.edit')
            ->with('success', $passwordChanged
                ? 'Your account and password have been updated.'
                : 'Your account details have been updated.');
    }
}
