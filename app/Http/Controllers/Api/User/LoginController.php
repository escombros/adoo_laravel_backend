<?php


namespace App\Http\Controllers\Api\User;

//Facades
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
//Models
use Illuminate\Http\Request;

use App\Models\User;
//Class
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ResponseApi;

class LoginController
{
    use ResponseApi;

    protected $redirectAuth;

    public function __construct()
    {
        //parent::__construct();

       // $this->redirectAuth = config('webcms.settings.manager.settings.redirectAuth', '/');
    }

    public function login(Request $request)
    {

        $rules = array(
            'id' => array('required', 'string'),
            'folio' => array('required', 'min:8'),
        );

        $input = $request->all();
        //dd($input);
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return $this->sendError('Validator', $validator->errors()->all(), 422);
        }

        $user = $this->_userAuthentication($input['id'], $input['folio']);

        //dd($admin);
        if (!$user) {
            return $this->sendError('Authentication', 'Usuario no encontrado', 403);
        }

        return $this->sendResponse($this->_createAccesTokenResponse($user));
    }


    private function _adminAuthentication($id, $folio, $status = true)
    {

        $credentials = [
            'id' => $email,
            'folio' => $status,
        ];
        //dd($credentials);
        $user = User::where($credentials)->first();
        // dd($admin->role);
        return $user ? $user : false;
    }

    private function _createAccesTokenResponse($user, $menssage = 'Personal Access Token FUD')
    {
        // dd($user->role);
        if($user->role===NULL){
            $user->role='*';
        }
        // dd($user->role);
        $tokenResult = $user->createToken($menssage, [$user->role])->accessToken;

        // $tokenResult = $user->createToken($menssage);

        // dd($tokenResult);
        // $route=(Route::has($this->redirectAuth))?route($this->redirectAuth):$this->redirectAuth;
        // $route = (!empty($this->redirectAuth)) ? url($this->redirectAuth) : $this->redirectAuth;
        // $route = $this->redirectAuth;

        return [
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
            // 'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            // 'access_token' => $tokenResult->plainTextToken,
            // 'token_type' => 'Bearer',
        ];
    }
}
