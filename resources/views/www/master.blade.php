@extends('innovative/core::www.master')

@section('jquery')
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="{{ HTML::asset('js/jquery.min.js') }}"><\/script>')</script>
@stop

@section('theme_css')
	@if( isset($_COOKIE['assetCached']) && $_COOKIE['assetCached'] !== false)
		<link rel="stylesheet" href="{{ HTML::asset('css/app.css') }}">
	@else
		<script>
			loadCSS('{{ HTML::asset('css/app.css') }}');
		</script>
	@endif
	<noscript>
		<link rel="stylesheet" href="{{ HTML::asset('css/app.css') }}">
	</noscript>
@stop

@section('polyfills')
	@if( view()->exists('www._partials.modernizr') )
	<script type="text/javascript">
		@include('www._partials.modernizr')
	</script>
	@endif
@stop

@section('js_bottom')
@parent
<script type="text/javascript" src="{{ HTML::asset('js/app.min.js') }}"></script>
@stop

{{--
***
* EVERYTHING BELOW CAN BE SCRAPPED
***
--}}

@section('title')
<title>Innovative Core 2.0</title>
@stop

@section('css_override')
@parent
<style>
	html, body {
		height: 100%;
	}

	body {
		margin: 0;
		padding: 0;
		width: 100%;
		display: table;
		font-weight: 100;
		font-family: 'Lato';
	}

	.container {
		text-align: center;
		display: table-cell;
		vertical-align: middle;
	}

	.content {
		text-align: center;
		display: inline-block;
	}

	.title {
		font-size: 96px;
	}

	.title,.quote { line-height: 1.2; }
</style>
@stop

@section('body')
	<div class="container">
		<div class="content">
			<div class="title">Innovative Core 2.0</div>
			<div class="quote">Powered by Laravel 5.1</div>
		</div>
	</div>
@stop

