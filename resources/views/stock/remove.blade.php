@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-tertiary">
				<div class="panel-heading">
					Estoque | Dar Baixa
				</div>

                <form id="formProduct" action="{{url('estoque/dar-baixa')}}" method="post" enctype="multipart/form-data">
                    <div class="panel-body">
                        {{ csrf_field() }}
                        @if(count($products) > 0)
                            <div class="table-responsive">                            
                                <table class="table table-bordered table-stripped" id="tableProductsList">
                                    <thead>
                                        <tr>
                                            <th>SKU</th>
                                            <th>Nome</th>
                                            <th>Quantidade em estoque</th>
                                            <th>Quantidade à dar baixa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                        <tr @if($product->quantity < 100) class="table-quantity-low" @endif>
                                            <td>
                                                <a href="{{ url('produtos/editar/' . $product->id) }}" title="Editar produto">{{$product->sku}}</a>
                                            </td>
                                            <td>{{$product->name}}</td>
                                            <td @if($product->quantity < 100) class="quantity-low" @endif>{{$product->quantity}} @if($product->quantity < 100) <small><i>Estoque baixo</i><small> @endif</td>
                                            <td class="text-center">
                                                <div class="form-group">
                                                    <input type="number" class="form-control inputQuantity" id="{{$product->id}}_quantity" placeholder="0000" name="{{$product->id}}_quantity" data-productid="{{$product->id}}">
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning" role="alert">
                                Nenhum produto cadastrado no estoque.
                            </div>
                            <div class="col-xs-12 text-center">
                                <a href="{{url('produtos/cadastrar')}}" class="btn btn-tertiary" title="Adicionar Novo Produto" alt="Adicionar Novo Produto">
                                Adicionar Novo Produto
                                </a>
                            </div>
                        @endif
                    </div>

                    @if(count($products) > 0)
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-xs-12 text-right">
                                <button type="submit" class="btn btn-tertiary" title="Alterar estoque" alt="Alterar estoque">
                                Alterar estoque
                                </a>
                            </div>
                        </div>
                    </div>    
                    @endif            
                </form>
			</div>
		</div>
	</div>
</div>
@endsection