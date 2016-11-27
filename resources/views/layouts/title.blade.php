<header class="page-header">
	<h2>
		@if(isset($backendHelper))
			{!! $backendHelper->getPageTitle() !!}
		@elseif(isset($title))
			{!! $title !!}
		@else
			{!! session('title', 'Backend') !!}
		@endif
	</h2>
</header>