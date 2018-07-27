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
						<table class="table table-bordered table-stripped" id="tableProductsList">
							<thead>
								<tr>
									<th width="80">Imagem</th>
									<th>SKU</th>
									<th>Nome</th>
									<th>Quantidade em estoque</th>
									<th width="180">Ação</th>
								</tr>
							</thead>
							<tbody>
								@foreach($products as $product)
								<tr>
									<td class="text-center">
										<img alt="Imagem do Produto" title="Imagem do Produto" class="img-thumbnail mx-auto d-block product-img-form" src="{{ url('uploads/produtos/' . ((isset($product) && $product->image) != null ? $product->image : 'default.png')) }}">
									</td>
									<td>
										<a href="{{ url('produtos/editar/' . $product->id) }}" title="Editar produto">{{$product->sku}}</a>
									</td>
									<td>{{$product->name}}</td>
									<td>{{$product->quantity}}</td>
									<td class="text-center">
										<a href="#" class="btn btn-sm btn-primary" title="Adicionar produtos ao estoque"><i class="fa fa-plus"></i></a>
										<a href="#" class="btn btn-sm btn-warning" title="Remover produtos do estoque"><i class="fa fa-minus"></i></a>
										<a href="{{ url('produtos/editar/' . $product->id) }}" class="btn btn-sm btn-success" title="Editar produto"><i class="fa fa-edit"></i></a>
										<a href="{{ url('produtos/excluir/' . $product->id) }}" class="btn btn-sm btn-danger" title="Excluir produto"><i class="far fa-trash-alt"></i></a>
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
@endsection