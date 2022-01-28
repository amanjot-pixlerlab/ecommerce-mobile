<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;

class ProductController extends BaseController
{
    /**
     * method to get all the products
     */
    public function get()
    {
        //set variable
        $products = [];

        //get all products
        try {
            $products = Product::paginate(9);
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
     * method to get filter result
     */
    public function filter($condition)
    {

        if(!isset($condition) || $condition === ''){
            return $this->handleError('No filters', ['error'=>"Please provide a filter condition"]);
        }

        //set variable
        $products = [];

        //get all products
        try {
            switch(strtolower($condition)){
                case 'lowtohigh': $products = Product::orderBy('price', 'asc')->paginate(9); break;
                case 'hightolow': $products = Product::orderBy('price', 'desc')->paginate(9); break;
                case 'date': $products = Product::orderBy('updated_at')->paginate(9); break;
                default : return $this->handleError('Not match', ['error'=>"Filter does not match. Available filters are 'lowtohigh', 'hightolow', 'date'"]);
            }
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
     * method to get search result
     */
    public function search($name)
    {
        //set variable
        $products = [];

        //get all products
        try {
            $products = Product::where('name','LIKE', '%'.$name.'%')->paginate(9);
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
}
