<?php
   
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;

   
class UserController extends BaseController
{

    /**
     * method for login
     */
    public function login(Request $request)
    {
        try {
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
                $auth = Auth::user(); 
                $success['token'] =  $auth->createToken('access_token')->plainTextToken; 
                $success['name'] =  $auth->name;
       
                return $this->handleResponse($success, 'User logged-in!');
            } 
            else{ 
                return $this->handleError('Unauthorised.', ['error'=>'Unauthorised']);
            } 
        } catch (\Throwable $th) {
            return $this->handleError('Database Error', ['error'=>$th]);
        }
    }

    /**
     * method for registration
     */
    public function register(Request $request)
    {
        //add user roles
        $user_roles = ['admin','customer','vendor'];

        //if there is no user role provided then it will be a customer
        if(!isset($request->role)){
            $request->role = 'customer';
        }

        //validate the required fields
        $validator = Validator::make($request->all(), [
            'name' => 'max:100',
            'phone' => 'numeric|digits:10',
            'role' => ['required', Rule::in($user_roles)],
            'email' => 'required|email|max:100',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|string|min:8|same:password',
        ]);
   
        //return with error if validation fails
        if($validator->fails()){
            return $this->handleError($validator->errors());       
        }

        try {
            //check if user email already exists
            if(User::where('email',$request->email)->first()){
                return $this->handleError('Duplicate value', ['error'=>'Email is already in use!']);
            }
    
            //insert data in the db and create a success token
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $success['token'] =  $user->createToken('access_token')->plainTextToken;
            $success['name'] =  $user->name;
       
            //return token with a success message
            return $this->handleResponse($success, 'User successfully registered!');
        } catch (\Throwable $th) {
            return $this->handleError('Database Error', ['error'=>$th]);
        }
    }


    /**
     * method to get current user
     */
    public function get(Request $request){
        try {
            $user = $request->user();
            return $this->handleResponse($user, 'User found!');
        } catch (\Throwable $th) {
            return $this->handleError('Database Error', ['error'=>$th]);
        }
    }

    /**
     * method for updating profile
     */
    public function update(Request $request)
    {
        //validate the required fields
        $validator = Validator::make($request->all(), [
            'name' => 'max:100',
            'phone' => 'numeric|digits:10',
            'email' => 'email|max:100',
        ]);
   
        //return with error if validation fails
        if($validator->fails()){
            return $this->handleError($validator->errors());       
        }

        $user = Auth::user();

        if(isset($request->name) && $request->name !== "")
            $user->name=$request->input('name');
        if(isset($request->phone) && $request->name !== "")
            $user->phone=$request->input('phone');
        if(isset($request->email) && $request->name !== ""){
            //check if email already exists
            $email_user = User::where('email',$request->email)->first();
            if($email_user){
                if(isset($email_user->id) && $email_user->id != $user->id){
                    return $this->handleError('Duplicate value', ['error'=>'Email is already in use!']);
                }
            }
            $user->email=$request->input('email');
        }

        // Save user to database
        $user->save();
        $success['name'] =  $user->name;
   
        //return token with a success message
        return $this->handleResponse($success, 'User updated successfully!');
    }

    /**
     * method to change password
     */
    public function change_password(Request $request) {
        
        $validator = Validator::make($request->all(),[
            'current_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8',
            'confirm_password' => 'required|string|min:8|same:new_password',
        ]);
        
        //return with error if validation fails
        if($validator->fails()){
            return $this->handleError($validator->errors());       
        }

        // Check if current password matches
        if (!(Hash::check($request->current_password, Auth::user()->password))) {
            return $this->handleError('Wrong password', ['error'=>'Your current password does not match with the password!']);
        }

        // Check if current password and new password are same
        if(strcmp($request->current_password, $request->new_password) == 0){
            return $this->handleError('Wrong password', ['error'=>'New Password and current password are same!']);
        }

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->new_password);
        $user->save();
        $success['name'] =  $user->name;

        return $this->handleResponse($success, 'Password changed successfully!');
    }
   
}