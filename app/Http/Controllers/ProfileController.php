<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Response;

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
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $photo = file_get_contents($image);

            $request->user()->photo = $photo;
        }

        $request->user()->save();

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

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function showImage(Request $request)
    {
        $user = User::find($request->id);

        if (!$user || !$user->photo) {
            $imagePath = public_path('adminlte\dist\img\avatar5.png');
            $image = file_get_contents($imagePath);

            return response()->make($image, 200, [
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'inline; filename="imagem.png"',
            ]);
        }

        return Response::make($user->photo, 200, [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'inline; filename="imagem.jpg"',
        ]);
    }
}
