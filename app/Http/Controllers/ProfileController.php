<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            $this->deleteImageFormFolder($user->image);
            // Store the new image
            $path = $request->file('image')->store('pictures');
            $user->image = $path;
        }
        
        $user->name = $request->name;
        $user->email = $request->email;
        // If email is updated, reset email verification
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Save the updated user
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $this->deleteImageFormFolder($user->image);
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function deleteImageFormFolder($imageName)
    {
        if ($imageName) {
            Storage::delete($imageName);
        }
    }
}
