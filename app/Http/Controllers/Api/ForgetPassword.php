<?php
   
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Validator;

   
class ForgetPassword extends BaseController
{

    /**
     * method for login
     */
    public function forget_password(Request $request){
        //You can add validation login here
        $user = User::where('email', $request->email)->first();

        //Check if the user exists
        if (!$user) {
            return $this->handleError('No user', ['error'=>'User does not exist!']);
        }

        // Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => substr(sha1(rand()), 0, 60),
            'created_at' => Carbon::now()
        ]);

        //Get the token just created above
        $tokenData = DB::table('password_resets')->where('email', $request->email)->first();
        if($tokenData && isset($tokenData->token) && $tokenData->token !== ""){
            $link = url('/').'/api/reset-passowrd/'.$tokenData->token;
        }
        if(isset($link)){

            echo $link;

            if (Mail::to($request->email)->send(new \App\Mail\EmailService("link : $link"))) {
                return ;
                // return $this->handleError('Wrong password', ['error'=>'Your current password does not match with the password!']);
                // return redirect()->back()->with('status', trans('A reset link has been sent to your email address.'));
            } else {
                return ;
                return $this->handleError('Mail failed', ['error'=>'A Network Error occurred. Please try again!']);
                // return redirect()->back()->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
            }
        }
    }

    /**
     * method to reset the password
     */
    public function reset_password(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email|max:100',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|string|min:8|same:password',
        ]);

        //return with error if validation fails
        if($validator->fails()){
            return $this->handleError($validator->errors());       
        }

        //check if token is correct 
        $updatePassword = DB::table('password_resets')->where([
            'email' => $request->email, 
            'token' => $request->token
        ])->first();

        if(!$updatePassword){
            return $this->handleError('Invalid token', ['error'=>'Invalid token!']);
        }

        $user = User::where('email', $request->email)
            ->update(['password' => bcrypt($request->new_password)]);
        
        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return $this->handleResponse($request->all(), 'Password reset successfully!');
    }
   
}