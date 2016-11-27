@if(session('success') === true)
	<div class="alert alert-success col-md-12" id="msgbox">
		<i class="fa fa-check"></i> ทำรายการสำเร็จ
	</div>
	<script>
	setTimeout(function() { $('#msgbox').slideUp(function() { $(this).remove() }); }, 2500);
	</script>
@elseif(session('success') and session('success') !== true)
   <div class="alert alert-danger col-md-12" id="msgbox">
		<i class="fa fa-close"></i> ผิดพลาด
		{!! session('success') !!}
	</div>
	<script>
	setTimeout(function() { $('#msgbox').slideUp(function() { $(this).remove() }); }, 2500);
	</script>
@endif