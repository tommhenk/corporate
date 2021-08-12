<div id="content-page" class="content group">
	<div class="hentry group">
        {!! Form::open(['url'=>( isset($user->id) ? route('admin_users_update', ['user'=>$user->id]) : route('admin_users_store') ), 'class'=>'contact-form' , "method"=>"POST", 'enctype'=>'multipart/form-data']) !!}
            <div class="usermessagea"></div>

                <ul>
                    <li class="text-field">
                        <label for="name-contact-us">
                        <span class="label">Имя:</span>
                        <br />					
                        <span class="sublabel">Имя</span><br />
                        </label>
                        <div class="input-prepend"><span class="add-on">
                        	<i class="icon-user"></i>
                        </span>
                        	{!! Form::text('name', isset($user->name) ? $user->name : old('name'), ['class'=> 'required']) !!}
                    	</div>
                        <div class="msg-error"></div>
                    </li>
                    <li class="text-field">
                        <label for="email-contact-us">
                        <span class="label">Логин:</span>
                        <br />					
                        <span class="sublabel">Логин</span><br />
                        </label>
                        <div class="input-prepend">
                        	{!! Form::text('login', isset($user->login) ? $user->login : old('login'), ['class'=> 'required']) !!}
                        </div>
                        <div class="msg-error"></div>
                    </li>
                    <div style="clear:both"></div>
                </ul>

                <ul>
                    <li class="text-field">
                        <label for="name-contact-us">
                        <span class="label">Email:</span>
                        <br />					
                        <span class="sublabel">Email</span><br />
                        </label>
                        <div class="input-prepend"><span class="add-on">
                        	<i class="icon-user"></i>
                        </span>
                        	{!! Form::text('email', isset($user->email) ? $user->email : old('email'), ['class'=> 'required']) !!}
                    	</div>
                        <div class="msg-error"></div>
                    </li>
                    <li class="text-field">
                        <label for="email-contact-us">
                        <span class="label">Пароль:</span>
                        <br />					
                        <span class="sublabel">Пароль</span><br />
                        </label>
                        <div class="input-prepend">
                        	{!! Form::text('password', '', ['class'=> 'required', 'type'=>'password']) !!}
                        </div>
                        <div class="msg-error"></div>
                    </li>
                    <div style="clear:both"></div>
                </ul>

                <ul>
                    <li class="text-field">
                        <label for="name-contact-us">
                        <span class="label">Повтор пароля:</span>
                        <br />					
                        <span class="sublabel">Повтор пароля</span><br />
                        </label>
                        <div class="input-prepend"><span class="add-on">
                        	<i class="icon-user"></i>
                        </span>
                        	{!! Form::text('password_confirmation', '', ['class'=> 'required']) !!}
                    	</div>
                        <div class="msg-error"></div>
                    </li>
                    <li class="text-field">
                        <label for="email-contact-us">
                        <span class="label">Роль:</span>
                        <br />					
                        <span class="sublabel">Роль</span><br />
                        </label>
                        <div class="input-prepend">
                        	@if ($roles)
	                        	{!! Form::select('role_id', $roles, isset($user) ? $user->roles()->first()->id : null,['placeholder'=>'Значение не выбрано']) !!}
	                        @endif
                        </div>
                        <div class="msg-error"></div>
                    </li>
                    <div style="clear:both"></div>
                </ul>

                    <ul>
                    	@if (isset($user->id))
                    		<input type="hidden" name="_method" value="PUT">
                    	@endif
                    	<li class="submit-button">
                    	{!! Form::button('Сохранить', ['type'=>'submit', 'class'=>'btn btn-the-salmon-dance']) !!}			
                    	</li>
                    </ul>
                    
                </ul>
        {!! Form::close() !!}
	</div>
</div>