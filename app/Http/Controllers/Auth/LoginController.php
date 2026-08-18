<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Persist session data that AuthenticateSession and the accounts module need.
     */
    protected function authenticated(Request $request, $user)
    {
        $request->session()->put(
            'password_hash_'.Auth::getDefaultDriver(),
            $user->getAuthPassword()
        );

        if ($request->filled('financial_year')) {
            $request->session()->put('financial_year', $request->input('financial_year'));
        }
    }

    /**
     * Log the user out and fully reset the session (CSRF + password hash).
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/login');
    }
}
