@extends('backendhelper::layouts.template')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			{!! 
				Form::open([
					'route'  => [$backendHelper->getBaseRoute().'.update', $backendHelper->getEditItem()->id],
					'method' => 'PUT',
					'class'  => 'form-horizontal form-bordered',
					'files'  => true,
				])
			!!}
				<div class="panel-body">
					@include('backendhelper::panelBody')
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-sm-10 col-sm-offset-2">
							<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Submit</button>
							<button type="reset" class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
							<a href="{{ route($backendHelper->getBaseRoute().'.index') }}" class="btn btn-info"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
			{!! Form::close() !!}
							@if($backendHelper->hasDeleteBtn())
								{!! 
									Form::open([
										'route'  => [$backendHelper->getBaseRoute().'.destroy', $backendHelper->getEditItem()->id], 
										'method' => 'DELETE', 
										'class'  => 'deleteForm',
										'style'  => 'display: inline'
									]) 
								!!}
									<button type="submit" class="btn btn-danger" data-toggle="tooltip" title="Delete"><i class="fa fa-remove"></i> Delete</button>
								{!! Form::close() !!}
							@endif
						</div>
					</div>
				</footer>
		</section>
	</div>
</div>
@endsection

@push('javascript')
    <script type="text/javascript">
    	$(document).ready(function() {
    		$('.datatable').dataTable();
    		$('form.deleteForm').submit(function(e) {
    			if(!confirm("คุณยืนยันที่จะลบข้อมูลนี้ใช่หรือไม่ ?")) {
    				e.preventDefault();
    			}
    		});
    	})
    </script>
@endpush