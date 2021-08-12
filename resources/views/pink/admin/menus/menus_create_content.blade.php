<div id="content-page" class="content group">
	<div class="hentry group">
        {!! Form::open(['url'=>( isset($menu->id) ? route('admin_menu_update', ['menu'=>$menu->id]) : route('admin_menu_store') ), 'class'=>'contact-form' , "method"=>"POST", 'enctype'=>'multipart/form-data']) !!}
            <div class="usermessagea"></div>

                <ul>
                    <li class="text-field">
                        <label for="name-contact-us">
                        <span class="label">Заголовок:</span>
                        <br />					
                        <span class="sublabel">Заголовок пункта</span><br />
                        </label>
                        <div class="input-prepend"><span class="add-on">
                        	<i class="icon-user"></i>
                        </span>
                        	{!! Form::text('title', isset($menu->title) ? $menu->title : old('title'), ['class'=> 'required']) !!}
                    	</div>
                        <div class="msg-error"></div>
                    </li>
                    <li class="text-field">
                        <label for="email-contact-us">
                        <span class="label">Родительский пункт меню:</span>
                        <br />					
                        <span class="sublabel">Родитель</span><br />
                        </label>
                        <div class="input-prepend">
                        	{!! Form::select('parent_id', $menus, isset($menu->parent_id) ? $menu->parent_id : null) !!}
                        </div>
                        <div class="msg-error"></div>
                    </li>
                </ul>

                <h1>Тип меню:</h1>

                <div id="accordion">
                	<h3>
                		{!! Form::radio('type', 'customLink', (isset($type) && $type == 'customLink' ) ? true : false) !!}
                		<span class="label">Пользовательская ссылка:</span>
                	</h3>

                	<ul>
                		<li class="text-field">
	                        <label for="email-contact-us">
	                        <span class="label">Путь для ссылки:</span>
	                        <br />					
	                        <span class="sublabel">Путь для ссылки</span><br />
	                        </label>
	                        <div class="input-prepend">
	                        	{!! Form::text('custom_link', (isset($type) && $type == 'customLink' && isset($menu)) ? $menu->path : false, ['class'=> 'required']) !!}
	                        </div>
	                        <div class="msg-error"></div>
                   		</li>
                   		<div style="clear:both"></div>
                   	</ul>

                   	
               		<h3>
                		{!! Form::radio('type', 'blogLink', (isset($type) && $type == 'blogLink' ) ? true : false) !!}
                		<span class="label">Раздел Блог:</span>
            		</h3>
            		<ul>
                   		<li class="text-field">
	                        <label for="email-contact-us">
	                        <span class="label">Ссылка на категорию блога:</span>
	                        <br />				
	                        <span class="sublabel">Ссылка на категорию блога</span>
	                        </label>
	                        <div class="input-prepend">
	                        @if ($categories)
	                        	{!! Form::select('category_alias', $categories, (isset($option) && $option) ? $option : false) !!}
	                        @endif
	                        	
	                        </div>
	                        <div class="msg-error"></div>
                   		</li>

	                	<li class="text-field">
	                        <label for="email-contact-us">
	                        <span class="label">Ссылка на материалы блога:</span>
	                        <br />					
	                        <span class="sublabel">Ссылка на материалы блога</span>
	                        <br />
	                        </label>
	                        <div class="input-prepend">
	                        	{!! Form::select('article_alias', $articles, (isset($option) && $option) ? $option : false) !!}
	                        </div>
	                        <div class="msg-error"></div>
                   		</li>
                   		<div style="clear:both"></div>
                   		</ul>

                   		
                   		<h3>
	                		{!! Form::radio('type', 'portfolioLink', (isset($type) && $type == 'portfolioLink' ) ? true : false) !!}
	                		<span class="label">Раздел Портфолио:</span>
                		</h3>
                		<ul>
                   		<li class="text-field">
	                        <label for="email-contact-us">
	                        <span class="label">Ссылка на запись портфолио:</span>
	                        <br />				
	                        <span class="sublabel">Ссылка на запись портфолио</span>
	                        </label>
	                        <div class="input-prepend">
	                        	{!! Form::select('portfolio_alias', $portfolios, (isset($option) && $option) ? $option : false) !!}
	                        </div>
	                        <div class="msg-error"></div>
                   		</li>

	                	<li class="text-field">
	                        <label for="email-contact-us">
	                        <span class="label">Ссылка на материалы блога:</span>
	                        <br />					
	                        <span class="sublabel">Ссылка на материалы блога</span>
	                        <br />
	                        </label>
	                        <div class="input-prepend">
	                        	{!! Form::select('filter_alias', $filters, (isset($option) && $option) ? $option : false) !!}
	                        </div>
	                        <div class="msg-error"></div>
                   		</li>
                   		<div style="clear:both"></div>
                	</ul>

                </div>
                    <ul>
                    	@if (isset($menu->id))
                    		<input type="hidden" name="_method" value="PUT">
                    	@endif
                    	<li class="submit-button">
                    	{!! Form::button('Сохранить', ['type'=>'submit', 'class'=>'sendmail alignright']) !!}			
                    	</li>
                    </ul>
                    
                </ul>
        {!! Form::close() !!}
	</div>
</div>
<script>
	jQuery(function($) {
		$('#accordion').accordion({
			activate: function (e, obj) {
				obj.newPanel.prev().find('input[type=radio]').attr('checked', 'checked');
			}
		});
		var active = 0;
		$('#accordion input[type=radio]').each(function (ind, it){
			if($(this).prop('checked')) {
				active = ind;
			}
		});

		$('#accordion').accordion('option', 'active', active);
	});
</script>