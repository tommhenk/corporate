@foreach ($items as $item)
	{{-- @dump(URL::current())
	@dd($item->url()); --}}
	<li {{ URL::current() == $item->url() ? "class=active" : "" }}>
		<a href="{{ $item->url() }}">{{ $item->title }}</a>
		@if ($item->hasChildren())
			
			<ul class="sub-menu">
				@include(config('settings.theme').'.customMenuItems', ['items'=>$item->children()])
			</ul>

		@endif
	</li>
@endforeach			