<?php

namespace App\Traits;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait CustomThrottleRequest
{
    /**
     * Determine if the user has too many failed login attempts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasTooManyAttempts(Request $request, $attempt = 5)
    {
        return $this->customlimiter()->tooManyAttempts(
            $this->customThrottleKey($request), $this->customMaxAttempts($attempt)
        );
    }

    /**
     * Increment the login attempts for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function incrementAttempts(Request $request, $minutes = 1)
    {
        $this->customlimiter()->hit(
            $this->customThrottleKey($request), $this->customDecayMinutes($minutes) * 60
        );
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function customLockoutResponse(Request $request)
    {
        $seconds = $this->customlimiter()->availableIn(
            $this->customThrottleKey($request)
        );
        return back()->withErrors(['alert-throttle' => translate('To many attempts. Please try again after seconds', ['seconds' => $seconds])]);
    }

    /**
     * Clear the login locks for the given user credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function clearAttempts(Request $request)
    {
        $this->customlimiter()->clear($this->customThrottleKey($request));
    }

    /**
     * Fire an event when a lockout occurs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function customFireLockoutEvent(Request $request)
    {
        event(new Lockout($request));
    }

    /**
     * Get the throttle key for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function customThrottleKey(Request $request)
    {
        $key = $request->getRequestUri().$request->getMethod();
        return Str::lower($key).'|'.$request->ip();
    }

    /**
     * Get the rate limiter instance.
     *
     * @return \Illuminate\Cache\RateLimiter
     */
    protected function customlimiter()
    {
        return app(RateLimiter::class);
    }

    /**
     * Get the maximum number of attempts to allow.
     *
     * @return int
     */
    public function customMaxAttempts($attempt)
    {
        return $attempt;
    }

    /**
     * Get the number of minutes to throttle for.
     *
     * @return int
     */
    public function customDecayMinutes($minutes)
    {
        return $minutes;
    }
}
