<?php

declare(strict_types=1);

//custom route finche' siamo legati ai modelli
// lista e' index, mostrare un elemento e' show ..

Route::get('{lang}/feed/{item}', 'RssFeedController@feed');
//Route::get('/sitemap.xml', 'SiteMapController@sitemap');
//Route::get('{lang}/feed/{item}', 'RssFeedController@show');
Route::get('/sitemap.xml', 'SiteMapController@index');