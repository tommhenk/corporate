<?php

return [
	'theme'=>env('THEME', 'default'),
	'slider_path'=>'slider-cycle',
	'home_port_count'=>5,
	'other_portfolios'=>8,
	'home_articles_count'=>3,
	'paginate'=>2,
	'resent_comments'=>3,
	'resent_portfolios'=>3,
	'articles_img' => [
							'max'=>['width'=> 816, 'height'=>282],
							'mini'=>['width'=> 55, 'height'=>55],
						],
	'portfolios_img' => [
							'max'=>['width'=> 770, 'height'=>368],
							'mini'=>['width'=> 175, 'height'=>175],
						],
	'image' => [
					'width'=>1024,
					'height'=>768
				],
]; 