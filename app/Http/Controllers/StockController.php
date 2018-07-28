<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use View;
use Session;

class StockController extends Controller
{
    public function add(){
        $products = Product::all();
        
        return View::make('stock.add')->with(compact('products'));
    }

    public function remove(){
        $products = Product::all();
        
        return View::make('stock.remove')->with(compact('products'));
    }

    public function changeStockAdd(Request $request){    
        $precess = $this->changeStockProcess($request->except('_token'), 'add');

        Session::flash('alert', $precess);            
        return redirect('estoque/adicionar');
    }

    public function changeStockRemove(Request $request){    
        $precess = $this->changeStockProcess($request->except('_token'), 'remove');

        Session::flash('alert', $precess);            
        return redirect('estoque/dar-baixa');
    }

    public function changeStockProcess($data, $type){
        $msg = '';
        $iSuccess = 0;
        $iErrors = 0;
        
        foreach($data as $key => $val){
            if($val !== null){
                $arrayKey = explode('_', $key);
            
                $product = Product::find($arrayKey[0]);

                if(is_numeric($val)){
                    if($type == 'remove' && ($val > $product->quantity)){
                        $msg .= 'Erro ao atualizar o produto <strong>' . $product->name . '</strong>. Quantidade a ser dado baixa deve ser menor ou igual a quantidade de produtos existente no estoque.' . "\n";
                        $iErrors++;
                    } else {
                        $product->quantity = ($type == 'add' ? ($product->quantity + $val) : ($product->quantity - $val));
                
                        if(!$product->save()){
                            $msg .= 'Erro ao atualizar o produto <strong>' . $product->name . '</strong>. Tende novamente.' . "\n";
                            $iErrors++; 
                        } else {
                            $iSuccess++;
                        }
                    }
                } else {
                    $msg .= 'Erro ao atualizar o produto <strong>' . $product->name . '</strong>. Quantidade informada inválida.' . "\n";
                    $iErrors++; 
                }
            }
        }
        
        if($msg == ''){
            $return = ['type' => 'success', 'msg' => 'Estoque atualizado com sucesso! ' . $iSuccess . ' produtos atualizados.'];            
        } else {
            $return = ['type' => 'warning', 'msg' => '<strong>' . $iSuccess . '</strong> produtos atualizados e <strong>' . $iErrors . '</strong> erros encontrados. Detalhes: ' . "\n" . $msg];
        }

        return $return;
    }
}
