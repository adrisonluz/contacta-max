@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel-group">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#collapse1">Filtro</a>
                            <a data-toggle="collapse" href="#collapse1" class="btn btn-xs pull-right" title="Filtrar" alt="Filtrar">
                                <i class="fa fa-filter"></i>
                            </a>
                        </h4>
                    </div>

                    <div id="collapse1" class="panel-collapse collapse">
                        <div class="panel-body">
                            <form id="formFilter" action="{{url('relatorios')}}" method="get">
                                
                                <div class="col-xs-6 col-sm-3">
                                    <div class="form-group">
                                        <label for="system">Sistema</label>
                                        <select class="form-control" id="system" name="system">
                                            <option value="">Todos</option>
                                            <option value="web" {{((Request::has('system') && Request::get('system') == 'web') ? 'selected="selected"' : '')}}>Web</option>
                                            <option value="api" {{((Request::has('system') && Request::get('system') == 'api') ? 'selected="selected"' : '')}}>Api</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-3">
                                    <div class="form-group">
                                        <label for="action">Ação</label>
                                        <select class="form-control" id="action" name="action">
                                            <option value="">Todos</option>
                                            <option value="add" {{((Request::has('action') && Request::get('action') == 'add') ? 'selected="selected"' : '')}}>Adicionar</option>
                                            <option value="remove" {{((Request::has('action') && Request::get('action') == 'remove') ? 'selected="selected"' : '')}}>Baixa</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-3">
                                    <div class="form-group">
                                        <label for="date">Data</label>
                                        <input type="text" class="form-control datepicker" id="date" name="date" value="{{(Request::has('date') ? Request::get('date') : '')}}">
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-3">
                                    <div class="form-group">
                                        <label for="submit">&nbsp;</label>
                                        <input type="submit" style="width: 100%;" id="submit" class="btn btn-primary" title="Filtrar" alt="Filtrar" value="Filtrar"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> 

			<div class="panel panel-primary">
				<div class="panel-heading">
					Relatórios | Listagem
				</div>

				<div class="panel-body">
					@if(count($logs) > 0)
						<div class="table-responsive">
							<table class="table table-bordered table-stripped" id="tablelogsList">
								<thead>
									<tr>
										<th>Produto</th>
										<th>Ação</th>
										<th>Quantidade</th>
										<th>Sistema</th>
										<th>Data</th>
									</tr>
								</thead>
								<tbody>
									@foreach($logs as $log)
									<tr>
										<td><strong>{{$log->product->sku}}</strong> <small>(<i>{{$log->product->name}}</i>)</small></td>
										<td>{{($log->action == 'add' ? 'Adicionar' : 'Baixa')}}</td>
										<td>{{$log->quantity}}</td>
										<td>{{$log->system}}</td>
										<td>{{$log->created_at}}</td>
                                        {{--<td>{{Carbon\Carbon::parse($log->created_at)->format('d/m/Y')}}</td>--}}
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>

                        <div class="text-center">
                            {{$logs->appends(Request::all())->links()}}
                        </div>
					@else
						<div class="alert alert-warning" role="alert">
							Nenhum registro encontrado.
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection