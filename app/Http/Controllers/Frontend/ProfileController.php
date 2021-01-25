<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $form = [
            'title' => 'Update',
            'action' => 'update',
            'passwords' => false,
            'action_route' => route('profile.update'),
            'method' => 'PUT',
        ];

        return view('backend.user.single')
            ->with('form', $form)
            ->with('user', auth()->user());
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        $user = $request->user();

        $user->fill($request->all());

        if ($request->hasFile('avatar')) {
            $imageController = new ImageController();

            $fileName     =
                $imageController->saveFile(
                    $request,
                    null,
                    'image',
                    'avatars'
                );
            $user->avatar = $fileName;
        }

        $user->save();

        $user->syncAddresses($request->input('address'), $request->input('country'), $request->input('state'), $request->input('city'));

        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        $request->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }
}
