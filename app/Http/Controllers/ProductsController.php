<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use View;
use Session;
use Illuminate\Support\Facades\Input;
use App\Log;

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

        if($request->has('add_products')){
            $product->quantity = ($product->quantity + $request->get('add_products'));
        }

        if($request->has('remove_products')){
            if($request->get('remove_products') > $product->quantity){
                Session::flash('alert', ['type' => 'danger', 'msg' => 'Erro ao processar solicitação. Não é possível remover produtos do estoque além da quantidade existente no mesmo. Por favor, informe um número menor ou igual a quantidade de produtos existente no estoque. Estoque atual: ' . $product->quantity . '.']);
                return redirect('produtos/editar/' . $product->id);
            } else {
                $product->quantity = ($product->quantity - $request->get('remove_products'));
            }
        }

        if($product->save()){
            $log = new Log;
            $log->system = 'web';
            $log->product_id = $product->id;
            $log->action = ($request->has('add_products') ? 'add' : 'remove');
            $log->quantity = ($request->has('quantity') ? $request->get('quantity') : $product->quantity);
            $log->save();

            Session::flash('alert', ['type' => 'success', 'msg' => 'Estoque de produto salvo com sucesso!']);            
        } else {
            Session::flash('alert', ['type' => 'danger', 'msg' => 'Erro ao salvar estoque do produto, por favor tente novamente mais tarde.']);
        }

        return redirect('produtos');
    }

    public function delete($id){
        $product = Product::find($id);

        if($product->delete()){
            Session::flash('alert', ['type' => 'success', 'msg' => 'Produto excluído com sucesso!']);            
        } else {
            Session::flash('alert', ['type' => 'danger', 'msg' => 'Erro ao processar solicitação, por favor tente novamente mais tarde.']);
        }
        
        return redirect('produtos');
    }

    public function restore($id){
        $product = Product::onlyTrashed()->find($id);

        if($product->restore()){
            Session::flash('alert', ['type' => 'success', 'msg' => 'Produto restaurado com sucesso!']);            
        } else {
            Session::flash('alert', ['type' => 'danger', 'msg' => 'Erro ao processar solicitação, por favor tente novamente mais tarde.']);
        }
        
        return redirect('produtos');
    }

    public function removeProductsApi(Request $request){
        $changeStock = $this->changeStockApi($request, 'remove');
        return $changeStock;
    }

    public function addProductsApi(Request $request){
        $changeStock = $this->changeStockApi($request, 'add');
        return $changeStock;
    }

    public function changeStockApi($request, $action){
        $validateProduct = $this->validateProduct($request);

        if($validateProduct['code'] !== 200){
            return [
                'code' => $validateProduct['code'],
                'mensagem'   => $validateProduct['msg'],
            ];
        }

        $product = $validateProduct['product'];

        $validateQuantity = $this->validateQuantity($request, $product, $action);
        
        if($validateQuantity['code'] !== 200){
            return [
                'code' => $validateQuantity['code'],
                'mensagem'   => $validateQuantity['msg'],
            ];
        }

        $quantity = $request->get('quantity');
        $product->quantity = ($action == 'add' ? ($product->quantity + $quantity) : ($product->quantity - $quantity));

        if($product->save()){
            $log = new Log;
            $log->system = 'api';
            $log->product_id = $product->id;
            $log->action = $action;
            $log->quantity = $quantity;
            $log->save();

            return [
                'code' => 200,
                'mensagem'   => 'Estoque atualizado com sucesso! Valor atual: ' . $product->quantity,
            ];
        } else {
            return [
                'code' => 500,
                'mensagem'   => 'Erro ao atualizar estoque do produto, por favor tente mais tarde.',
            ];
        }
    }

    public function validateProduct($request){
        $data = [];
        if(!$request->has('id') && !$request->has('sku')) {
            $data = [
                'code' => 400,
                'msg'   => 'Id e Sku inválidos ou inexistentes na requisição.',
            ];
        }

        if($request->has('id')){
            $product = Product::find($request->get('id'));
        } elseif($request->has('sku')){
            $product = Product::where('sku', $request->get('sku'))->first();
        }

        if(!$product) {
            $data = [
                'code' => 404,
                'msg'   => 'Produto não encontrado com os dados de identificação informados.',
            ];
        } else {
            $data = [
                'code' => 200,
                'msg'   => 'Produto validado.',
                'product' => $product
            ];
        }

        return $data;
    }

    public function validateQuantity($request, $product, $action){
        if(!$request->has('quantity')){
            $data = [
                'code' => 400,
                'msg'   => 'Parâmetro "quantity" não encontrado ou inválido'
            ];
        } elseif(!is_numeric($request->get('quantity'))){
            $data = [
                'code' => 400,
                'msg'   => 'O valor de "quantity" precisa ser um valor numérico.'
            ];
        } elseif($action == 'remove' && $request->get('quantity') > $product->quantity){
            $data = [
                'code' => 400,
                'msg'   => 'Não é possível remover produtos do estoque além da quantidade existente no mesmo. Por favor, informe um número menor ou igual a quantidade de produtos existente no estoque.'
            ];
        } else {
            $data = [
                'code' => 200,
                'msg'   => 'Quantidade válida.'
            ];
        }

        return $data;
    }

    public function checkProductBySku(Request $request){
        $sku = $request->get('sku');
        $product = Product::withTrashed()->where('sku', $sku)->first();
        return $product;
    }

    public function verifyStock(Request $request, $id){
        $product = Product::find($id);
        $quantity = $request->get('quantity');
        
        $return = (($product->quantity >= $quantity) ? 'success' : 'error');
        return $return;
    }
}
