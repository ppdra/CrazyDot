<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        $throttleKey = 'login:'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            throw ValidationException::withMessages([
                'email' => ['IP blocked due to too many attempts. Please try again later.'],
            ]);
        }

        $email = strtolower(trim((string) $request->input('email')));
        $password = (string) $request->input('password');

        $user = User::query()->where('email', $email)->first();

        if (! $user) {
            RateLimiter::hit($throttleKey, 60);

            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        if (! Auth::attempt(['email' => $email, 'password' => $password])) {
            RateLimiter::hit($throttleKey, 60);

            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();

        $tz = $request->input('timezone');
        $request->session()->put(
            'tz',
            ($tz && in_array($tz, timezone_identifiers_list())) ? $tz : 'UTC'
        );

        return redirect()->intended(route('home'));
    }
}
