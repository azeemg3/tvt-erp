<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;

/**
 * Keep Jetstream AuthenticateSession in sync when switching users.
 *
 * A GET logout that only called Auth::logout() left password_hash_web from the
 * previous user in the session. The next login regenerated that session, the
 * middleware saw a hash mismatch, and silently logged the new user out.
 */
class StorePasswordHashInSession
{
    public function handle(Login $event): void
    {
        $request = request();

        if (! $request->hasSession() || ! $event->user) {
            return;
        }

        $request->session()->put(
            'password_hash_'.Auth::getDefaultDriver(),
            $event->user->getAuthPassword()
        );

        if ($request->filled('financial_year')) {
            $request->session()->put('financial_year', $request->input('financial_year'));
        }
    }
}
