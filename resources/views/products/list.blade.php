@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                	Produtos | Listagem
                	<a href="{{url('produtos/cadastrar')}}" class="btn btn-primary btn-xs pull-right" title="Novo Produto" alt="Novo Produto">
                		<i class="fa fa-plus"></i>
            		</a>
            	</div>

                <div class="panel-body">
                	@if(count($products) > 0)
                    <table class="table table-bordered table-striped">
					  <thead>
					    <tr>
							<th scope="col">Imagem</th>
							<th scope="col">SKU</th>
							<th scope="col">Nome</th>
							<th scope="col">Quantidade em estoque</th>
							<th scope="col">Ação</th>
					    </tr>
					  </thead>
					  <tbody>
					  	@foreach($products as $product)
					    <tr>
							<td>
								{{asset('uploads/produtos/' . ($product->image or 'default.png'))}}
							</td>
							<td>{{$product->sku}}</td>
							<td>{{$product->name}}</td>
							<td>{{$product->qtd}}</td>
							<td>
								
							</td>
					    </tr>
					    @endforeach
					  </tbody>
					</table>
					@else
						<div class="alert alert-warning" role="alert">
							Nenhum produto cadastrado no estoque.
						</div>
					@endif
                </div>

                <div class="panel-footer">
	            	<div class="row">
		            	<div class="col-xs-12 text-right">
							<a href="{{url('produtos/cadastrar')}}" class="btn btn-primary" title="Novo Produto" alt="Novo Produto">
			            		Novo Produto
			        		</a>
		            	</div>
	            	</div>
	            </div>
            </div>
        </div>
    </div>
</div>
@endsection