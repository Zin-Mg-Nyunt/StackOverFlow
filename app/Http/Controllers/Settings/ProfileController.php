<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('settings/Profile', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request, User $user): RedirectResponse
    {
        $updatedData=$request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'profile_photo_path' => 'nullable|image|max:2048'
        ]);

        if ($request->delete_photo) {
            $updatedData['profile_photo_path'] = null;
        }else{
            if($request->hasFile('profile_photo_path')){
                if($user->profile_photo_path){
                    Storage::disk('public')->delete($user->getRawOriginal('profile_photo_path'));
                }
                $path=$request->profile_photo_path->store('profiles','public');
                $updatedData['profile_photo_path'] = $path;
            }else{
                $updatedData=collect($updatedData)->except('profile_photo_path')->toArray();
            };
        }
        
        $user->fill($updatedData);
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->save();
        return back();
    }

    /**
     * Delete the user's profile.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

}
