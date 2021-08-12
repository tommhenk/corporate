@if ( $filters )
<div id="content-page" class="content group">
	<div class="hentry group">

		 {!! Form::open(['url'=>(isset($portfolio->id) ? route('admin_portfolio_update', ['portfolio'=>$portfolio->id]) : route('admin_portfolio_store')), 'class'=>'contact-form', 'method'=>'POST', 'enctype'=>"multipart/form-data" ]) !!}

            <fieldset>
                <ul>
                    <li class="text-field">
                        <label for="name-contact-us">
                        <span class="label">Название</span>
                        <br />					
                        <span class="sublabel">Заголовок материала</span><br />
                        </label>
                        <div class="input-prepend"><span class="add-on">
                        	<i class="icon-user"></i>
                        </span>
                        {!! Form::text('title', isset($portfolio->title) ? $portfolio->title : old('title'), ['placeholder'=>'title']) !!}
                    </div>
                        <div class="msg-error"></div>
                    </li>

                    <li class="text-field">
                        <label for="name-contact-us">
                        <span class="label">Заказчик:</span>
                        <br />					
                        <span class="sublabel">Заказчик материала</span><br />
                        </label>
                        <div class="input-prepend"><span class="add-on">
                        	<i class="icon-user"></i>
                        </span>
                        {!! Form::text('customer', isset($aportfolio->customer) ? $portfolio->customer : old('customer'), ['placeholder'=>'customer']) !!}
                    </div>
                        <div class="msg-error"></div>
                    </li>

                    <li class="text-field">
                        <label for="name-contact-us">
                        <span class="label">Псевдоним:</span>
                        <br />					
                        <span class="sublabel">Псевдоним материала</span><br />
                        </label>
                        <div class="input-prepend"><span class="add-on">
                        	<i class="icon-user"></i>
                        </span>
                        {!! Form::text('alias', isset($portfolio->alias) ? $portfolio->alias : old('alias'), ['placeholder'=>'alias']) !!}
                    </div>
                        <div class="msg-error"></div>
                    </li>
                    <li class="text-field">
                        <label for="name-contact-us">
                        <span class="label">Фильтр:</span>
                        <br />					
                        <span class="sublabel">Фильтр материала</span><br />
                        </label>
                        <div class="input-prepend"><span class="add-on">
                        	<i class="icon-user"></i>
                        </span>
                        {!! Form::select('filter_id', $filters, isset($article->filter_id) ? $article->filter_id : old('filter_id')) !!}
                    </div>
                        <div class="msg-error"></div>
                    </li>

                    <li class="textarea-field">
                        <label for="name-contact-us">
                        <span class="label">Описание:</span>
                        <br />					
                        <span class="sublabel">Описание материала</span><br />
                        </label>
                        <div class="input-prepend"><span class="add-on">
                        	<i class="icon-user"></i>
                        </span>
                        {!! Form::textarea('text', isset($portfolio->text) ? $portfolio->text : old('text'), ['placeholder'=>'text', 'id'=>'editor']) !!}
                    </div>
                        <div class="msg-error"></div>
                    </li>



                    @isset ( $portfolio->img->path )
                    
                    <li class="text-field">
                        <label for="name-contact-us">
                        <span class="label">Изображение материала:</span>
                        <br />					
                        <span class="sublabel">Заголовок материала</span><br />
                        </label>
                        
                        {!! Html::image(config('settings.theme').'/images/projects/'.$portfolio->img->path) !!}
                        {{ Form::hidden('old_img', $portfolio->img->path) }}
                    </li>
                    
                    @endisset
                    
                    <li class="text-field">
                        <label for="name-contact-us">
                        <span class="label">Изображение:</span>
                        <br />					
                        <span class="sublabel">Заголовок материала</span><br />
                        </label>
                        <div class="input-prepend">
                        {!! Form::file('img', ['class'=>'filestyle', 'data-text'=>'Выберете изображение', 'data-buttonName'=>'btn btn-primary', 'data-placeholder'=>'Файла нет']) !!}
                    </div>
                        <div class="msg-error"></div>
                    </li>


                    @isset ($portfolio->id)
                        <input type="hidden" name="_method" value="PUT">
                    @endisset
                    

                    <li class="submit-button">
                        {!! Form::button('Сохранить', ['class'=>'btn btn-primary', 'type'=>'submit']) !!}			
                    </li>
                </ul>
            </fieldset>
        {!! Form::close() !!}
        <script>
        	CKEDITOR.replace( 'editor' );
        	$(":file").filestyle();
        </script>
	</div>

</div>
@endif