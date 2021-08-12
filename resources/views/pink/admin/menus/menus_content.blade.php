<div id="content-page" class="content group">
	<div class="hentry group">
		<h3 class="title_page">Пользватели</h3>

		<div class="short-table white">
			<table style="widows: 100%;" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th>Name</th>
						<th>Link</th>
						<th>Удалить</th>
					</tr>
				</thead>
				@if ($menus)
					@include(config('settings.theme').'.admin.menus.castom-menu-items', ['items'=>$menus->roots(), 'paddingLeft'=>''])
				@endif
			</table>
		</div>		
		{!! Html::link(route('admin_menu_create'), 'Добавить пункт', ['class'=>'btn btn-the-salmon-dance-3']) !!}
	</div>
</div>