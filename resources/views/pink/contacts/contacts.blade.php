@extends(config('settings.theme').'.layouts.site')

@section('navigation')
	{!! $navigation !!}
@endsection

@if ($errors->count() > 0)
	<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>	
	</div>
@endif

@if ( !empty( session('status') ) )
	<div class="box success-box">
		<p>{{ session('status') }}</p>
	</div>
@endif

@section('content')
	{!! $content !!}
@endsection

@section('bar')
	{!! $leftBar !!}
@endsection

@section('footer')
	{!! $footer !!}
@endsection
