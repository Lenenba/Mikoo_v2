<?php

namespace App\Http\Controllers\Settings;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Settings\BabysitterProfileRequest;

class BabysitterProfileController extends Controller
{
    /**
     * Show the form for creating a new babysitter profile.
     *
     * @return \Inertia\Response
     */
    public function edit()
    {
        return Inertia::render('settings/babysitter-profile', [
            'babysitterProfile' => Auth::user()->babysitterProfile,
            'role'  => Auth::user()->isBabysitter(),
        ]);
    }

    /**
     * Update the babysitter profile in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BabysitterProfileRequest $request)
    {
        // Validate & get only the filled data
        $data = $request->validated();

        // Get the authenticated user
        $user = Auth::user();
        // Get the user's profile
        $profile = $user->babysitterProfile();
        // Attempt to update: update() ne lancera le save() que s’il y a des attributs modifiés
        $updated = $profile->update($data);

        if ($updated) {
            return redirect()
                ->back()
                ->with('success', 'Profile details updated!');
        }

        // Aucune donnée n’a changé
        return redirect()
            ->back()
            ->with('info', 'No changes detected.');
    }
}
