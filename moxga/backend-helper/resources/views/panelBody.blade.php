@include('backendhelper::assets.notify')
@include('backendhelper::assets.validation')

@foreach($backendHelper->getFieldList() as $field)
	@if($field->getType() == 'hidden')
		{!! $field->render() !!}
	@else
		<div class="form-group">
			{!! Form::label($field->getName(), $field->getLabel(), ['class' => 'control-label col-sm-2']) !!}
			<div class="col-sm-7">
				{!! $field->render() !!}
			</div>
		</div>
	@endif
@endforeach