@if ( $categories )
<div id="content-page" class="content group">
	<div class="hentry group">

		 {!! Form::open(['url'=>(isset($article->id) ? route('admin_articles_update', ['alias'=>$article->alias]) : route('admin_articles_store')), 'class'=>'contact-form', 'method'=>'POST', 'enctype'=>"multipart/form-data" ]) !!}

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
                        {!! Form::text('title', isset($article->title) ? $article->title : old('title'), ['placeholder'=>'title']) !!}
                    </div>
                        <div class="msg-error"></div>
                    </li>

                    <li class="text-field">
                        <label for="name-contact-us">
                        <span class="label">Ключевые слова</span>
                        <br />					
                        <span class="sublabel">Заголовок материала</span><br />
                        </label>
                        <div class="input-prepend"><span class="add-on">
                        	<i class="icon-user"></i>
                        </span>
                        {!! Form::text('keywords', isset($article->keywords) ? $article->keywords : old('keywords'), ['placeholder'=>'keywords']) !!}
                    </div>
                        <div class="msg-error"></div>
                    </li>

                    <li class="text-field">
                        <label for="name-contact-us">
                        <span class="label">Мета описание</span>
                        <br />					
                        <span class="sublabel">Заголовок материала</span><br />
                        </label>
                        <div class="input-prepend"><span class="add-on">
                        	<i class="icon-user"></i>
                        </span>
                        {!! Form::text('meta_desc', isset($article->meta_desc) ? $article->meta_desc : old('meta_desc'), ['placeholder'=>'meta_desc']) !!}
                    </div>
                        <div class="msg-error"></div>
                    </li>
                    <li class="text-field">
                        <label for="name-contact-us">
                        <span class="label">Псевдоним</span>
                        <br />					
                        <span class="sublabel">Заголовок материала</span><br />
                        </label>
                        <div class="input-prepend"><span class="add-on">
                        	<i class="icon-user"></i>
                        </span>
                        {!! Form::text('alias', isset($article->alias) ? $article->alias : old('alias'), ['placeholder'=>'alias']) !!}
                    </div>
                        <div class="msg-error"></div>
                    </li>

                    <li class="textarea-field">
                        <label for="name-contact-us">
                        <span class="label">Краткое описание</span>
                        <br />					
                        <span class="sublabel">Заголовок материала</span><br />
                        </label>
                        <div class="input-prepend"><span class="add-on">
                        	<i class="icon-user"></i>
                        </span>
                        {!! Form::textarea('desc', isset($article->desc) ? $article->desc : old('desc'), ['placeholder'=>'desc', 'id'=>'editor']) !!}
                    </div>
                        <div class="msg-error"></div>
                    </li>

                    <li class="textarea-field">
                        <label for="name-contact-us">
                        <span class="label">Описание</span>
                        <br />					
                        <span class="sublabel">Заголовок материала</span><br />
                        </label>
                        <div class="input-prepend"><span class="add-on">
                        	<i class="icon-user"></i>
                        </span>
                        {!! Form::textarea('text', isset($article->text) ? $article->text : old('text'), ['placeholder'=>'text', 'id'=>'editor2']) !!}
                    </div>
                        <div class="msg-error"></div>
                    </li>

                    @isset ( $article->img->path )
                    
                    <li class="text-field">
                        <label for="name-contact-us">
                        <span class="label">Изображение материала:</span>
                        <br />					
                        <span class="sublabel">Заголовок материала</span><br />
                        </label>
                        
                        {!! Html::image(config('settings.theme').'/images/articles/'.$article->img->path) !!}
                        {{ Form::hidden('old_img', $article->img->path) }}
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

                    <li class="text-field">
                        <label for="name-contact-us">
                        <span class="label">Категория:</span>
                        <br />					
                        <span class="sublabel">Категория материала</span><br />
                        </label>
                        <div class="input-prepend">
                        {!! Form::select('category_id', $categories, isset($article->category_id) ? $article->category_id : old('category_id')) !!}
                    </div>
                        <div class="msg-error"></div>
                    </li>

                    @isset ($article->id)
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
        	CKEDITOR.replace('editor2');
        	$(":file").filestyle();
        </script>
	</div>

</div>
@endif