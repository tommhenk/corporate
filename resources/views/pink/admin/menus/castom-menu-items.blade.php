@foreach ($items as $item)
	<tr>

		<td style="text-align: left;">{{ $paddingLeft }} {{ Html::link(route('admin_menu_edit', ['menu'=>$item->id]), $item->title ) }}</td>
		<td>{{ $item->url() }}</td>

		<td>
			{!! Form::open(['url'=>route('admin_menu_destroy', ['menu'=>$item->id]), 'method'=>"POST", 'class'=>'form']) !!}
			{{ method_field('DELETE') }}
			{!! Form::button('Удалить', ['class'=>'btn btn-french-5', 'type'=>'submit']) !!}
			{!! Form::close() !!}

		</td>
	</tr>		
	@if ($item->hasChildren())
			@include(config('settings.theme').'.admin.menus.castom-menu-items', ['items'=>$item->children(),'paddingLeft'=>'--' ])
	@endif	
@endforeach