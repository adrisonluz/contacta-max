<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use View;
use Session;

class ProductsController extends Controller
{
    public function list(){
        $products = Product::all();
        
        return View::make('products.list')->with(compact('products'));
    }

    public function add()
    {
        return View::make('products.form');
    }

    public function edit()
    {
        return View::make('products.form');
    }

    public function save()
    {
        
    }

    public function delete()
    {
        
    }

    public function removeProducts(){
        
    }

    public function addProducts(){

    }
}
