@extends('backendhelper::layouts.template')

@push('stylesheet')
	<style type="text/css">
		form.deleteForm {
			display: inline-block;
		}
	</style>
@endpush

@section('content')
	<section class="panel">
		<div class="panel-body">
			@if($backendHelper->hasAddBtn())
				<div class="text-right mb-md">
					<a href="{{ $backendHelper->getAddBtnUrl() ?: route($backendHelper->getBaseRoute().'.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add</a>
				</div>
			@endif
			<table class="table table-bordered table-striped mb-none datatable">
				<thead>
					<tr>
						@foreach($backendHelper->getColumnList() as $column)
							<th>{!! $column->getColumnName() !!}</th>
						@endforeach
						<th>Created Date</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>
					@foreach($backendHelper->getDataList() as $data)
						<tr>
							@foreach($backendHelper->getColumnList() as $column)
								<td>{{ str_limit($column->getColumnValue($data), 64) }}</td>
							@endforeach

							<td>{{ $data->created_at->format('d-m-Y H:i:s') }}</td>
							<td>
								@foreach($backendHelper->getActionList() as $action)
									{!! $action->render($data) !!}
								@endforeach
								@if($backendHelper->hasEditBtn())
									<a href="{{ route($backendHelper->getBaseRoute().'.edit', $data->id) }}" class="btn btn-info" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
								@endif
								@if($backendHelper->hasDeleteBtn())
									{!! 
										Form::open([
											'route'  => [$backendHelper->getBaseRoute().'.destroy', $data->id], 
											'method' => 'DELETE', 
											'class'  => 'deleteForm'
										]) 
									!!}
										<button type="submit" class="btn btn-danger" data-toggle="tooltip" title="Delete"><i class="fa fa-remove"></i></button>
									{!! Form::close() !!}
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</section>
@endsection

@push('javascript')
    <script type="text/javascript">
    	$(document).ready(function() {
    		$('.datatable').dataTable({
                "order": [[ 0, "desc" ]]
			});
    		$('form.deleteForm').submit(function(e) {
    			if(!confirm("คุณยืนยันที่จะลบข้อมูลนี้ใช่หรือไม่ ?")) {
    				e.preventDefault();
    			}
    		});
    	})
    </script>
@endpush