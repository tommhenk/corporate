@if ( $articles )
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
					<th>Категория</th>
					<th>Псевдоним</th>
					<th>Действие</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($articles as $article)
					<tr>
						
						<td class="align-left">{{ $article->id }}</td>
						<td>{!! Html::link(route('admin_articles_edit', ['alias'=>$article->alias]), $article->title, ['alt'=>$article->title]) !!}</td>
						<td>{{ Str::limit($article->text, 200) }}</td>
						<td>{{ Html::image(config('settings.theme').'/images/articles/'.$article->img->mini) }}</td>
						<td>{{ $article->category->tilte }}</td>
						<td>{{ $article->alias }}</td>
						<td>
							{!! Form::open(['url'=>route( 'admin_articles_destroy', ['alias'=>$article->alias] ), 'class'=>"form-horizontal", 'method'=>'POST' ]) !!}
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
	{!! Html::link(route('admin_articles_create'), 'Новая страница',['class'=>'btn btn-primary']) !!}
</div>
@endif