<div id="content-page" class="content group">
	<div class="hentry group">

		<h3>Привелегии</h3>

		{!! Form::open(['url'=>route('admin_permission_store'), 'method'=>'POST', /*'class'=>'content contact-form'*/]) !!}

		<div class="short-table white">
			<table style="width:100%">
				<thead>
					<tr>
						<th>Привелегии</th>
						
						@empty ( $roles->isEmpty() )
						    @foreach ($roles as $item)
						    	<th>{{ ucfirst($item->name) }}</th>
						    @endforeach
						@endempty		
					</tr>
				</thead>
				<tbody>
						@empty ($perms->isEmpty())
						    @foreach ($perms as $val)
						    	<tr>
						    		<td>{{ $val->name }}</td>

						    		@foreach ($roles as $role)
						    			{{-- <td><input type="text" name="" value="" id=""></td> --}}
						    			@if ($role->hasPermission($val->name))
						    				<td>
						    					<input type="checkbox" name="{{$role->id}}[]" value="{{$val->id}}" id="" checked="true">
						    				</td>
						    			@else
						    				<td>
						    					<input type="checkbox" name="{{$role->id}}[]" value="{{$val->id}}" id="" >
						    				</td>
						    			@endif
						    			
						    		@endforeach
						    	</tr>		
						    @endforeach
						@endempty
				</tbody>		
			</table>
		</div>		

		{!! Form::button('Сохранить', ['class' => 'btn btn-salmon-dance-3','type'=>'submit']) !!}
		{!! Form::close() !!}


	</div>	
</div>