<div class="widget-first widget recent-posts">
    <h3>{{ Lang::get('ru.latest_projects') }}</h3>
    <div class="recent-post group">
    	@if (!$portfolios->isEmpty())
    		@foreach ($portfolios as $portfolio)
    			
    		<div class="hentry-post group">
	            <div class="thumb-img"><img src="{{ asset(config('settings.theme')) }}/images/projects/{{ $portfolio->img->mini }}" style="width: 55px;" alt="001" title="001" /></div>
	            <div class="text">
	                <a href="{{ route('portfolio.show', ['alias'=>$portfolio->alias]) }}" title="{!! $portfolio->title !!}" class="title">{!! $portfolio->title !!}</a>
	                {!! Str::limit($portfolio->text, 100) !!}
	                <a class="read-more" href="{{ route('portfolio.show', ['alias'=>$portfolio->alias]) }}">&rarr; {{ Lang::get('ru.read_more') }}</a>
	            </div>
	        </div>

    		@endforeach		
    	@endif		

    </div>
</div>

@if ( !$comments->isEmpty() )
<div class="widget-last widget recent-comments">
    <h3>{{ Lang::get('ru.latest_comments') }}</h3>
    <div class="recent-post recent-comments group">

    	@foreach ($comments as $comment)
    		<div class="the-post group">
	            <div class="avatar">
	            	@set($hash, ($comment->user) ? md5($comment->user->email) : md5($comment->email))
	                <img alt="" src="https://www.gravatar.com/avatar/{{$hash}}?d=mm&s=55" class="avatar" />   
	            </div>
	            <span class="author"><strong><a href="#">{{ $comment->user->name ? $comment->user->name : $comment->name }}</a></strong> in</span> 
	            <a class="title" href="{{ route('articles.show', ['alias'=>$comment->article->alias]) }}">{!! $comment->article->title !!}</a>
	            <p class="comment">
	            	{!! Str::limit($comment->text, 70) !!}
	                 <a class="goto" href="{{ route('articles.show', ['alias'=>$comment->article->alias]) }}">&#187;</a>
	            	
	            </p>
	        </div>
    	@endforeach



        

    </div>
</div>


@endif
