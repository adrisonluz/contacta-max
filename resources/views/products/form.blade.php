@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">                
                <div class="panel-heading">
                	Produtos | Criar/Editar 
            	</div>
				
				<form action="{{url('produtos/salvar/' . (isset($product) ? $product->id  : ''))}}" method="post" enctype="multipart/form-data">
	                <div class="panel-body">
						<div class="col-xs-12 col-sm-8">
							{{ csrf_field() }}
							@if(isset($product))
							<input type="hidden" name="id" value="{{$product->id}}"/>
							@endif

							<div class="form-group">
								<label for="sku">SKU</label>
								<input type="text" class="form-control" id="sku" placeholder="010203abcde" name="sku" value="{{$product->sku or ''}}">
							</div>

							<div class="form-group">
								<label for="name">Nome</label>
								<input type="text" class="form-control" id="name" placeholder="Nome do produto" name="name" value="{{$product->name or ''}}">
							</div>

							<div class="form-group">
								<label for="quantity">Quantidade em estoque</label>
								<input type="text" class="form-control" id="quantity" placeholder="100" name="quantity" value="{{$product->quantity or ''}}" @if(isset($product)) disabled @endif)>
							</div>

							@if(isset($product))
							<div class="form-group">
								<label for="">Adicionar / Remover produtos do estoque</label>
								<br>
								<a href="#" class="btn btn-sm btn-primary" title="Adicionar produtos ao estoque"><i class="fa fa-plus"></i></a>
								<a href="#" class="btn btn-sm btn-danger" title="Remover produtos do estoque"><i class="fa fa-minus"></i></a>
							</div>	
							@endif
						</div>

	                	<div class="col-xs-12 col-sm-4">
							<div class="form-group">
								<label for="sku">Imagem</label>

	                            <div class="text-left">
	                                <img alt="Imagem do Produto" title="Imagem do Produto" class="img-thumbnail mx-auto d-block product-img-form" src="{{ url('uploads/produtos/' . ((isset($product) && $product->image) != null ? $product->image : 'default.png')) }}">
	                            </div>

	                            <input type="file" class="form-control-file" id="image" name="image">
	                        </div>
						</div>

						<div class="col-xs-12">
							<div class="form-group">
								<label for="description">Descrição</label>
								<textarea class="form-control" id="description" rows="5" name="description">{{$product->description or ''}}</textarea>
							</div>
						</div>
	                </div>

	                <div class="panel-footer">
		            	<div class="row">
							<div class="col-xs-6">
								<a href="{{url('produtos')}}" class="btn" title="Voltar para produtos" alt="Voltar para produtos">
								<i class="fa fa-arrow-left"></i> Voltar
								</a>
			            	</div>
			            	
							<div class="col-xs-6 text-right">
								<input type="submit" class="btn btn-primary" title="Salvar" alt="Salvar" value="Salvar"/>
			            	</div>
		            	</div>
		            </div>
	            </form>
            </div>
        </div>
    </div>
</div>
@endsection