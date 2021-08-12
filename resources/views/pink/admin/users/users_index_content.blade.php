@if ( $users )
<div id="content-page" class="content group">
	<div class="hentry group">
		<h2>Добавленные статьи</h2>
		<div class="short-table white">
			<table style="width: 100%" cellspacing="0">
			<thead>
				<tr>
					<th class="align-left">ID/th>
					<th>Name</th>
					<th>Email</th>
					<th>Login</th>
					<th>Role</th>
					<th>Действие</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($users as $user)
					<tr>
						<td class="align-left">{{ $user->id }}</td>
						<td>{!! Html::link(route('admin_users_edit', ['user'=>$user->id]), $user->name, ['alt'=>$user->name]) !!}</td>
						<td>{{ $user->email }}</td>
						<td>{{ $user->login }}</td>

						{{-- <td>{{ $user->roles->implode('name', ', ') }}</td> --}}
						<td>{{ $user->roles }}</td>
						<td>
							{!! Form::open(['url'=>route( 'admin_users_destroy', ['user'=>$user->id] ), 'class'=>"form-horizontal", 'method'=>'POST' ]) !!}
							{{ method_field('delete') }}
							{!! Form::button('Удалить', ['class'=> 'btn btn-french-5', 'type'=>'submit']) !!}
							{!! Form::close() !!}
						</td>
					</tr>		
				@endforeach
			</tbody>
		</table>
	</div>
	</div>
	{!! html::link(route('admin_users_create'), 'Добавить ползователя',['class'=>'btn btn-primary']) !!}
</div>
@endif