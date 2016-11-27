@if(isset($backendHelper))
	@foreach($menuList as $menu)
		@if(!count($menu->getSubMenu()))
			<li>
				<a href="{{ $menu->getUrl() }}">
					<i class="{{ $menu->getIcon() }}" aria-hidden="true"></i>
					<span>{{ $menu->getName() }}</span>
				</a>
			</li>
		@else
			<li class="nav-parent">
				<a>
					<i class="fa fa-{{ $menu->getIcon() }}" aria-hidden="true"></i>
					<span>{{ $menu->getName() }}</span>
				</a>
				<ul class="nav nav-children">
					@include('backendhelper::layouts.menu', ['menuList' => $menu->getSubMenu()])
				</ul>
			</li>
		@endif
	@endforeach
@endif