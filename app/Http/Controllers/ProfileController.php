<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Contracts\ProfileRepositoryInterface;
use App\Http\Requests\DestroyAccountRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProfileController extends Controller
{
    protected $profileRepository;

    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function index(User $user)
    {

        return Inertia::render('Profile/View', [
            'mustVerifyEmail' => $user instanceof MustVerifyEmail,
            'status' => session('status'),
            'user' => new UserResource($user),
            'isCurrentUserFollower' => '',
            'followerCount' => '',
            'posts' => '',
            'followers' => '',
            'followings' => ')',
            'photos' =>''
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $updateDetails = [
            'username' => $request->username,
            'email' => $request->email
        ];
        DB::beginTransaction();
        try{
             $post = $this->profileRepository->update($user,$updateDetails);

             DB::commit();
             return to_route('profile', $request->user())->with('success', 'Your profile details were updated.');

        }catch(\Exception $ex){
            return ApiResponseClass::rollback($ex);
        }

    }

    protected function resetEmailVerificationIfChanged($user, $request)
    {
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(DestroyAccountRequest $request): RedirectResponse
    {
        $request->validated();
        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updateImage(UpdateImageRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();

        $avatar = $data['avatar'] ?? null;
        $cover = $data['cover'] ?? null;

        $success = '';
        if ($cover) {
            if ($user->cover_path) {
                Storage::disk('public')->delete($user->cover_path);
            }
            $path = $cover->store('user-' . $user->id, 'public');
            $user->update(['cover_path' => $path]);
            $success = 'Your cover image was updated';
        }

        if ($avatar) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $path = $avatar->store('user-' . $user->id, 'public');
            $user->update(['avatar_path' => $path]);
            $success = 'Your avatar image was updated';
        }

    //    session('success', 'Cover image has been updated');

        return back()->with('success', $success);
    }
}
