@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">                
                <div class="panel-heading">
                	Produtos | Criar/Editar 
            	</div>
				
				<form action="{{url('produtos/' . (isset($product) ? $product->id . '/' : '') . 'salvar')}}" method="post" enctype="multipart/form-date">
	                <div class="panel-body">
	                	<div class="col-xs-12 col-sm-6">
							<div class="form-group">
								<label for="sku">Imagem</label>

								@if(isset($product))
	                            <div class="text-left">
	                                <img alt="Imagem do Produto" title="Imagem do Produto" class="img-thumbnail mx-auto d-block" src="{{ url('uploads/produtos/' . ($product->image != null ? $product->image : 'default.png')) }}">
	                            </div>
	                            @endif

	                            <input type="file" class="form-control-file" id="image" name="image">
	                        </div>
						</div>

						<div class="col-xs-12 col-sm-6">
							<div class="form-group">
								<label for="sku">SKU</label>
								<input type="text" class="form-control" id="sku" placeholder="010203abcde" name="sku" value="{{$product->sku or ''}}">
							</div>

							<div class="form-group">
								<label for="name">Nome</label>
								<input type="text" class="form-control" id="name" placeholder="Nome do produto" name="name" value="{{$product->name or ''}}">
							</div>

							<div class="form-group">
								<label for="qtd">Quantidade em estoque</label>
								<input type="text" class="form-control" id="qtd" placeholder="100" name="qtd" value="{{$product->qtd or ''}}">
							</div>
						</div>

						<div class="col-xs-12">
							<div class="form-group">
								<label for="description">Descrição</label>
								<textarea class="form-control" id="description" rows="3" name="description" value="{{$product->description or ''}}"></textarea>
							</div>
						</div>
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
	            </form>
            </div>
        </div>
    </div>
</div>
@endsection