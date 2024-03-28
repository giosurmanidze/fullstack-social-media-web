<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProfileController extends Controller
{

    public function index(User $user)
    {

        dd($user);
        // return Inertia::render('Profile/View', [
        //     'mustVerifyEmail' => $user instanceof MustVerifyEmail,
        //     'status' => session('status'),
        //     'success' => 'success',
        //     'isCurrentUserFollower' => '$isCurrentUserFollower',
        //     'followerCount' => '$followerCount',
        //     'user' => 'new UserResource($user)',
        //     'posts' => '$posts',
        //     'followers' => 'UserResource::collection($followers)',
        //     'followings' => 'UserResource::collection($followings)',
        //     'photos' =>' PostAttachmentResource::collection($photos)'
        // ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
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

        return Redirect::to('/');
    }
}
