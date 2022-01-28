<?php

namespace App\Http\Controllers\Api;

use App\Models\PopularProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;

class PopularProductController extends BaseController
{
    /**
     * method to get all the popular products
     */
    public function get()
    {
        //set variable
        $products = [];

        //get all products
        try {
            $products = PopularProduct::paginate(9);
        } catch (\Throwable $th) {
            return $this->handleError('Error in collecting data', ['error'=>$th]);
        }

        //return error if no product is found
        $count = count($products);
        if($count <= 0){
            return $this->handleError('Empty', ['error'=>'No data found']);
        }

        return $this->handleResponse($products, $count.' '.($count == 1?'product has':'products have').' been retrieved!');
    }

    /**
     * method to get add new popular product
     */
    public function add(Request $request)
    {
        if(!isset($request->product_id)){
            return $this->handleError('No product id', ['error'=>'Please provide a product id.']);
        }

        try {
            //check if product exists
            if(!Product::where('id',$request->product_id)->first()){
                return $this->handleError('No product', ['error'=>'The product does not exist. Please make sure the id is correct.']);
            }

            //check if product already exists in popular products table
            if(PopularProduct::where('product_id',$request->product_id)->first()){
                return $this->handleError('Duplicate value', ['error'=>'Product already exists in popular products table!']);
            }

            
            $input = $request->all();
            $popular_product = PopularProduct::create($input);
            $success = ['product_id' =>$request->product_id];
    
            return $this->handleResponse($success, 'Product added successfully!');
        } catch (\Throwable $th) {
            return $this->handleError('Database Error', ['error'=>$th]);
        }
    }

    

    /**
     * method to get add new popular product
     */
    public function delete(Request $request)
    {
        if(!isset($request->product_id)){
            return $this->handleError('No product id', ['error'=>'Please provide a product id.']);
        }

        try {
            //check if product exists in popular products table
            if(!PopularProduct::where('product_id',$request->product_id)->first()){
                return $this->handleError('No product', ['error'=>'The product does not exist. Please make sure the id is correct.']);
            }
            
            PopularProduct::where('product_id',$request->product_id)->delete();
            $success = ['product_id' =>$request->product_id];

            return $this->handleResponse($success, 'Product deleted successfully!');
        } catch (\Throwable $th) {
            return $this->handleError('Database Error', ['error'=>$th]);
        }
    }
    
}
