<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Image;
use App\Models\Profile;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        $payload = [
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ];
        $user = User::create($payload);
        $payload = [
            'user_id' => $user->id,
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'birthdate' => $request->input('birthdate'),
            'location' => $request->input('location'),
            'bio' => $request->input('bio'),
        ];
        $user->profile()->create($payload);
        return customResponse()
            ->data($user)
            ->message('User was successfully created.')
            ->success()
            ->generate();
    }

    public function update(User $user, UpdateUserRequest $request)
    {
        $payload = [
            'bio' => $request->input('bio'),
            'location' => $request->input('location'),
        ];
        $user->profile()->update($payload);
        $profile = $user->profile->refresh();
        $picture = $request->file('new_picture');
        if (!empty($picture)) {
            $location = 'users';
            $uploaded = ImageService::uploadImage($picture, $location);
            $profile->image()->update($uploaded);
            ImageService::deleteImage($uploaded);
        }

        return customResponse()
            ->data($user->load(['profile', 'profile.image']))
            ->message('User was successfully updated.')
            ->success()
            ->generate();
    }
}
