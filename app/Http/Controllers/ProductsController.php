<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use View;
use Session;
use Illuminate\Support\Facades\Input;

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

    public function edit($id)
    {
        $product = Product::find($id);

        if(!$product){
            Session::flash('alert', ['type' => 'danger', 'msg' => 'Produto não encontrado.']);
            return redirect('produtos');
        }

        return View::make('products.form')->with(compact('product'));
    }

    public function save(Request $request)
    {
        if($request->has('id')){
            $product = Product::find($request->get('id'));
        } else {
            $product = new Product;
        }

        $product->sku = $request->get('sku');
        $product->name = $request->get('name');
        $product->quantity = ($request->has('quantity') ? $request->get('quantity') : $product->quantity);
        $product->description = $request->get('description');
        
        if(Input::hasFile('image')) {
            $ext = Input::file('image')->getClientOriginalExtension();
            $product->image = (isset($product->image) ? $product->image : date('dmYHis')) . '.' . $ext;
            Input::file('image')->move('uploads/produtos', $product->image);
        }

        if($product->save()){
            Session::flash('alert', ['type' => 'success', 'msg' => 'Produto salvo com sucesso!']);            
        } else {
            Session::flash('alert', ['type' => 'danger', 'msg' => 'Erro ao salvar produto, por favor tente novamente mais tarde.']);
        }

        return redirect('produtos');
    }

    public function delete()
    {
        
    }

    public function removeProducts(){
        
    }

    public function addProducts(){

    }
}
