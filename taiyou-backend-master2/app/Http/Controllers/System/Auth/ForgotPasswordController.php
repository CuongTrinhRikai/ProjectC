<?php

namespace App\Http\Controllers\system\Auth;

use App\Exceptions\CustomGenericException;
use App\Http\Controllers\Controller;
use App\Mail\system\PasswordResetEmail;
use App\Services\System\UserService;
use App\Traits\CustomThrottleRequest;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails, CustomThrottleRequest;

    public function __construct(UserService $user)
    {
        $this->user = $user;
    }
    public function showRequestForm()
    {
        $title = 'Forgot-password';
        return view('system.auth.forgotPassword', compact('title'));
    }

    public function handleForgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email:rfc,dns']);
        try {
            if (
                method_exists($this, 'hasTooManyAttempts') &&
                $this->hasTooManyAttempts($request, 5) // maximum attempts can be set by passing parameter $attempts=
            ) {
                $this->customFireLockoutEvent($request);

                return $this->customLockoutResponse($request);
            }

            $this->incrementAttempts($request, 1); // maximum decay minute can be set by passing parameter $minutes=

            $this->sendPasswordResetLink($request->email);

            return back()->withErrors(['alert-success' => "Password reset link has been sent to your email."]);
        } catch (\Exception $e) {
            throw new CustomGenericException($e->getMessage());
        }
    }

    public function sendPasswordResetLink($email)
    {
        $user = $this->user->findByEmail($email);
        $token = $this->user->generateToken(24);
        $encryptedToken = encrypt($token);
        $user->update([
            'token' => $token
        ]);
        Mail::to($user->email)->send(new PasswordResetEmail($user, $encryptedToken));
    }
}
