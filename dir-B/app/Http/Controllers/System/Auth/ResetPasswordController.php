<?php

namespace App\Http\Controllers\system\Auth;

use App\Exceptions\CustomGenericException;
use App\Http\Controllers\Controller;
use App\Http\Requests\system\setResetRequest;
use App\Services\System\UserService;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Config;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;
    public function __construct(UserService $user)
    {
        $this->service = $user;
    }

    public function showSetResetForm(Request $request)
    {
        try {
            $data['title'] = 'Set Password';
            if ($request->route()->getName() == "reset.password") {
                $data['title'] = 'Reset Password';
            }
            $this->service->findByEmailAndToken($request->email, $request->token);
            $data['email'] = $request->email;
            $data['token'] = $request->token;
            return view('system.auth.setPassword', $data);
        } catch (\Exception $e) {
            throw new NotFoundHttpException();
        }
    }

    public function handleSetResetPassword(setResetRequest $request)
    {
        if ($this->setResetPassword($request)) {
            $redirect = redirect(PREFIX . '/login');
            $msg = ['alert-success' => translate('Password has been successfully set.')];
        } else {
            $redirect = back();
            $msg = ['alert-danger' => translate('Please provide the new password.')];
        }
        return $redirect->withErrors($msg);
    }

    public function setResetPassword($request)
    {
        try {
            $user = $this->service->findByEmailAndToken($request->email, $request->token);

            $check = $this->checkOldPasswords($user, $request);
            if ($check) {
                $password = Hash::make($request->password);
                if ($user->userPasswords->count() < 3) {
                    $user->userPasswords()->create(['password' => $password]);
                }
                $user->update([
                    'password' => $password,
                    'password_resetted' => 1,
                    'token' => $this->service->generateToken(24)
                ]);

                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            throw new CustomGenericException($e->getMessage());
        }
    }

    public function checkOldPasswords($user, $request)
    {
        $oldPasswords = $user->userPasswords()->get();
        $check = true;
        foreach ($oldPasswords as $oldPassword) {
            if (Hash::check($request->password, $oldPassword->password)) {
                $check = false;
                break;
            }
        }
        return $check;
    }
}
