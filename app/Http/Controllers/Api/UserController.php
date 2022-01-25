<?php
   
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Validator;

   
class UserController extends BaseController
{

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $auth = Auth::user(); 
            $success['token'] =  $auth->createToken('LaravelSanctumAuth')->plainTextToken; 
            $success['name'] =  $auth->first_name;
   
            return $this->handleResponse($success, 'User logged-in!');
        } 
        else{ 
            return $this->handleError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    public function register(Request $request)
    {
        //add user roles
        $user_roles = ['admin','customer','vendor'];

        //validate the required fields
        $validator = Validator::make($request->all(), [
            'first_name' => 'max:50',
            'last_name' => 'max:50',
            'phone' => 'numeric|digits:10',
            'role' => ['required', Rule::in($user_roles)],
            'email' => 'required|email|max:100',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
   
        //return with error if validation fails
        if($validator->fails()){
            return $this->handleError($validator->errors());       
        }

        //insert data in the db and create a success token
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('LaravelSanctumAuth')->plainTextToken;
        $success['name'] =  $user->first_name;
   
        //return token with a success message
        return $this->handleResponse($success, 'User successfully registered!');
    }
   
}