<?php

namespace App\Http\Middleware\Frontend;

use App\Traits\Api\ResponseTrait;
use Carbon\Carbon;
use Closure;
use Auth;


class frontendAuth
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::guard('buildingAdmins')->user();
        if($user!= null){
            $token_expiration_date = Carbon::parse($user->token()->expires_at);
            $today = Carbon::now();
            if ($today > $token_expiration_date) {
                $request->user()->token()->revoke();
                return $this->setStatusCode(401)->userUnauthenticated('Your session has been expired.');
            }
            $request = $this->addUserToRequest($request);
            return $next($request);
        }else{
            return $this->setStatusCode(401)->userUnauthenticated('Your session has been expired.');
        }

    }

    private function addUserToRequest($request)
    {
        $user = Auth::guard('buildingAdmins')->user();
        $request->merge([
            'user' => $user,
            'company_id' => $user->contractor->company_id
        ]);
        $request->setUserResolver(function () use ($user) {
            return $user;
        });
        Auth::setUser($user);
        return $request;
    }
}
