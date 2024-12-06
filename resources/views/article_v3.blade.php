@php
/**
* $articles 對應 news_article
* $imageGroupKey 為 NewsArticle關聯ArticleThree的方法名, ex: threes
**/
// $builder = new Article($articles, $imageGroupKey);

$ArticlePath = "App\Http\Controllers\\".Config::get('blade_template')."\Article";
$builder = new $ArticlePath($articles, $imageGroupKey);

@endphp

{!! $builder->buildArticle() !!}
