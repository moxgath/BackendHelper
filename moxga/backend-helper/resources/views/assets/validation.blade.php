@if(session('success') !== true)
	@if(count($errors))
	<div id="alert-box" class="validation-message">
		<ul style="display: block;">
			@foreach($errors->all() as $error)
			<li>
				<label class="error" style="display: inline-block;">{!! $error !!}</label>
			</li>
			@endforeach
		</ul>
	</div>
	@elseif(session('error'))
		<div id="alert-box" class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			{!! session('error') !!}
		</div>
	@elseif(session('success'))
		<div id="alert-box" class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			{!! session('success') !!}
		</div>
	@endif
@endif