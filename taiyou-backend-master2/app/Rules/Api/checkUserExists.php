<?php

namespace App\Rules\Api;

use App\User;
use App\Model\FrontendUser;
use App\Traits\Api\ResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Model\System\BuildingAdmin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class checkUserExists implements Rule
{
    use ResponseTrait;
    /**
     * @var BuildingAdmin
     */
    private $frontendUser;
    private $password;
    /**
     * @var string
     */
    private $type;
    /**
     * @var BuildingAdmin
     */
    private $backendUser;

    /**
     * Create a new rule instance.
     *
     * @param $password
     * @param string $type
     */
    public function __construct($password,$username)
    {
        $this->password = $password;
        $this->frontendUser = new BuildingAdmin();
        $this->username = $username;
        // $this->backendUser = new User();
        // $this->type = $type;

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {



    //     $loginID = DB::table('oauth_access_tokens')->pluck('revoked')->first();

    //   if( !$loginID ){
    //      return $this->setStatusCode(401)->userUnauthenticated('already login');
    //   }
        $user = $this->frontendUser->where('username', $value)->first();

            if (isset($user) && Hash::check($this->password, $user->password)) {

                return true;
            } else {
                return false;
            }


        // if ($this->type == 'backend') {
        //     $user = $this->backendUser->where('username', $value)->first();
        // }


    }

    // /**
    //  * Get the validation error message.
    //  *
    //  * @return string
    //  */
    public function message()
    {

        return 'ユーザー名とパスワードを正しくご入力してください。';
    }
}
