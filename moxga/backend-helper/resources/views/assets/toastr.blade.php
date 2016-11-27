@if(isset($error) || isset($success) || session('error') || session('success'))
	<?php
		$action = (isset($error) || session('error')) ? 'error' : 'success';
		$message = (isset($error) || session('error')) ? (session('error') ?: $error) : (session('success') ?: $success);
	?>
	@push('javascript')
		<script type="text/javascript">
			toastr.{{ $action }}("{!! $message !!}");
		</script>
	@endpush
@endif