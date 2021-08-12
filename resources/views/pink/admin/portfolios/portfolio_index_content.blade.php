@if ( $portfolios )
<div id="content-page" class="content group">
	<div class="hentry group">
		<h2>Добавленные статьи</h2>
		<div class="short-table white">
			<table style="width: 100%" cellspacing="0">
			<thead>
				<tr>
					<th class="align-left">ID/th>
					<th>Заголовок</th>
					<th>Текст</th>
					<th>Изображение</th>
					<th>Фильтр</th>
					<th>Псевдоним</th>
					<th>Действие</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($portfolios as $portfolio)
					<tr>
						
						<td class="align-left">{{ $portfolio->id }}</td>
						<td>{!! Html::link(route('admin_portfolio_edit', ['portfolio'=>$portfolio->id]), $portfolio->title, ['alt'=>$portfolio->title]) !!}</td>
						<td>{{ Str::limit($portfolio->text, 200) }}</td>
						<td>{{ Html::image(config('settings.theme').'/images/projects/'.$portfolio->img->mini) }}</td>
						<td>{{ $portfolio->filter->title }}</td>
						<td>{{ $portfolio->alias }}</td>
						<td>
							{!! Form::open(['url'=>route( 'admin_portfolio_destroy', ['portfolio'=>$portfolio->id] ), 'class'=>"form-horizontal", 'method'=>'POST' ]) !!}
							{{-- {!! Form::hidden('_method', 'delete') !!} --}}
							{{ method_field('delete') }}
							{!! Form::button('Удалить', ['class'=> 'btn btn-danger', 'type'=>'submit']) !!}
							{!! Form::close() !!}
						</td>
					</tr>		
				@endforeach
			</tbody>
		</table>
	</div>
	</div>
	{!! html::link(route('admin_portfolio_create'), 'Новая страница',['class'=>'btn btn-primary']) !!}
</div>
@endif