<?php

namespace App\Http\Controllers\Api\auth;

use Exception;
use Carbon\Carbon;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Services\Api\LoginService;
use Illuminate\Support\Facades\DB;
use App\Model\System\BuildingAdmin;
use Illuminate\Support\Facades\Auth;
use App\Transformers\TokenTransformer;
use App\Http\Requests\Api\LoginRequest;
use GuzzleHttp\Exception\ClientException;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\SocialLoginRequest;
use App\Http\Requests\Api\RefreshTokenRequest;


class LoginController extends ApiController
{
    public function __construct(LoginService $service)
    {
        parent::__construct(new Manager());
        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     operationId="login",
     *     tags={"Building Admin"},
     *     summary="BuildinAdmin Login",
     *     description="login using access token",
     *     @OA\RequestBody(
     *             @OA\JsonContent(
     *                 required={"grantType", "clientId","clientSecret"},
     *                 @OA\Property(
     *                     property="grantType",
     *                     type="string",
     *                     default="password",
     *                 ),
     *                 @OA\Property(
     *                     property="username",
     *                     type="string",
     *                     default="username"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     default="Password",
     *                 ),
     *           @OA\Property(
     *                     property="clientId",
     *                     type="integer",
     *                     default="clientId",
     *                 ),
     *          @OA\Property(
     *                     property="clientSecret",
     *                     type="string",
     *                     default="Enter clientSecret",
     *                 ),
     *              @OA\Property(
     *                     property="refreshToken",
     *                     type="string",
     *                     default=" refreshToken",
     *                 ),
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Authorized",
     *     ),
     * )
     */
    public function login(LoginRequest $request)
    {
        if ($request->grantType == 'password') {
            $user = BuildingAdmin::where('username', $request->username)->first();

            $othuser = DB::table('oauth_access_tokens')->where('user_id', $user->id)->latest()->first();

            if (isset($othuser)) {

                if ($othuser->expires_at <= Carbon::now()->format('Y-m-d H:i:s')) {
                    DB::table('oauth_access_tokens')->where('user_id', $user->id)->update([
                        'revoked' => 1
                    ]);
                    $othuser->revoked = 1;
                }
                if ($othuser->revoked == 0) {
                    return $this->setStatusCode(401)->userUnauthenticated('先にログアウトしてください。');
                }
            }
            try {
                $data = $request->all();
                $data = $this->service->parseFormat($data);

                $tokenData = $this->service->generateToken($data);

                return $this->respondWithItem($tokenData, new TokenTransformer, 'login');
            } catch (Exception $e) {
                return $this->errorInternalError($e->getMessage());
            }
        }
        try {

            $data = $request->all();

            $data = $this->service->parseFormat($data);
            $data['refresh_token'] = $data['refreshToken'];
            unset($data['refreshToken']);


            $tokenData = $this->service->generateToken($data);

            return $this->respondWithItem($tokenData, new TokenTransformer, 'login');
        } catch (Exception $e) {

            return $this->errorInternalError($e->getMessage());
        }
    }

    public function socialLogin(SocialLoginRequest $request)
    {
        try {
            if ($request->provider == "google") {
                $tokenData = $this->service->loginWithgoogle($request);
            } elseif ($request->provider == "facebook") {
                $tokenData = $this->service->loginWithFacebook($request);
            } elseif ($request->provider == "apple") {
                $tokenData = $this->service->loginWithApple($request);
            } else {
                return $this->errorInternalError('Social-login setup needs to be done.');
            }
            return $this->respondWithItem($tokenData, new TokenTransformer, 'social-login');
        } catch (ClientException $e) {
            return $this->errorInternalError('Expired Token.');
        } catch (Exception $e) {
            return $this->errorInternalError($e->getMessage());
        }
    }


    public function refreshToken(RefreshTokenRequest $request)
    {
        try {

            $data = $request->all();
            $data = $this->service->parseFormat($data);
            $data['refresh_token'] = $data['refreshToken'];
            unset($data['refreshToken']);

            $tokenData = $this->service->generateToken($data);

            return $this->respondWithItem($tokenData, new TokenTransformer, 'login');
        } catch (Exception $e) {
            return $this->errorInternalError($e->getMessage());
        }
    }

    /**
     * @OA\Post (
     *     path = "/logout",
     *     operationId = "logout",
     *     tags = {"Building Admin"},
     *     summary = "building Admin logout",
     *     security = {
     *      {"bearer_token":{}}
     *     },
     *     @OA\Response(
     *     response = "200",
     *     description = "Authorized",
     *     )
     * )
     */
    public function logout(Request $request)
    {

        $tokenRepository = app('Laravel\Passport\TokenRepository');
        $user = auth('buildingAdmins')->user();

        if ($user) {
            $tokenRepository->revokeAccessToken($user->token()->id);
            return response()->json(['success' => 'Logout_success.'], 200);
        } else {
            return response()->json(['success' => 'Already logged out.'], 200);
        }
    }

    /**
     * @OA\Post(
     *     path="/verify-user",
     *     operationId="Verify User",
     *     tags={"Building Admin"},
     *     summary="Verify User",
     *     description="Verify User using access token",
     *     security = {
     *      {"bearer_token":{}}
     *     },
     *     @OA\RequestBody(
     *             @OA\JsonContent(
     *                 required={"grantType", "clientId","clientSecret"},
     *                 @OA\Property(
     *                     property="grantType",
     *                     type="string",
     *                     default="password",
     *                 ),
     *                 @OA\Property(
     *                     property="username",
     *                     type="string",
     *                     default="username"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     default="Password",
     *                 ),
     *           @OA\Property(
     *                     property="clientId",
     *                     type="integer",
     *                     default="clientId",
     *                 ),
     *          @OA\Property(
     *                     property="clientSecret",
     *                     type="string",
     *                     default="Enter clientSecret",
     *                 ),
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Authorized",
     *     ),
     * )
     */
    public function verifyUser(LoginRequest $request)
    {
        if (strtolower($request->username) == strtolower($request->user()->username)) {

            return response()->json(['success' => frontTrans('Valid User.')], 200);
        } else {

            return response()->json(['error' => frontTrans('InValid User.')], 401);
        }

    }
}
