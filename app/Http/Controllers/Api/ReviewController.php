<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;

class ReviewController extends BaseController
{
    /**
     * method to get all the popular products
     */
    public function get($product_id)
    {
        if(!isset($product_id) || $product_id === ''){
            return $this->handleError('No product id', ['error'=>'Please provide a product id.']);
        }

        //set variable
        $reviews = [];

        //get all reviews
        try {
            $reviews = Review::where('product_id', $product_id)->paginate(3);
        } catch (\Throwable $th) {
            return $this->handleError('Error in collecting data', ['error'=>$th]);
        }

        //return error if no product is found
        $count = count($reviews);
        if($count <= 0){
            return $this->handleError('Empty', ['error'=>'No data found']);
        }

        return $this->handleResponse($reviews, $count.' '.($count == 1?'product has':'products have').' been retrieved!');
    }

    /**
     * method to get add new popular product
     */
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'rating' => 'required|int',
            'product_id' => 'required|int',
        ]);
        
        //return with error if validation fails
        if($validator->fails()){
            return $this->handleError($validator->errors());       
        }

        try {
            //check if product exists
            if(!Product::where('id',$request->product_id)->first()){
                return $this->handleError('No product', ['error'=>'The product does not exist. Please make sure the product id is correct.']);
            }

            //check if active status is provided
            if(!isset($request->active_status)){
                $request['active_status'] = 'active';
            }

            //check if user exists
            if(isset($request->user_id)){
                if(!User::where('id',$request->user_id)->first()){
                    return $this->handleError('No user', ['error'=>'The user does not exist. Please make sure the user id is correct.']);
                }
            }else{
                $user = Auth::user();
                $request['user_id'] = $user->id;
            }

            $input = $request->all();
            $review = Review::create($input);
    
            return $this->handleResponse($review, 'Review added successfully!');
        } catch (\Throwable $th) {
            return $this->handleError('Database Error', ['error'=>$th]);
        }
    }

    

    /**
     * method to get add new popular product
     */
    public function delete(Request $request)
    {
        if(!isset($request->review_id)){
            return $this->handleError('No id', ['error'=>'Please provide an id.']);
        }

        try {
            //check if product exists in popular products table
            if(!Review::where('id',$request->review_id)->first()){
                return $this->handleError('No review', ['error'=>'The review does not exist. Please make sure the id is correct.']);
            }
            
            Review::where('id',$request->review_id)->delete();
            $success = ['review_id' =>$request->review_id];

            return $this->handleResponse($success, 'Review deleted successfully!');
        } catch (\Throwable $th) {
            return $this->handleError('Database Error', ['error'=>$th]);
        }
    }
    
}
