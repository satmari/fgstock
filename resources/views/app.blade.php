<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>FGStock</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/css.css') }}" rel="stylesheet">
	<!-- <link href="{{ asset('/css/bootstrap.min.css') }}" rel='stylesheet' type='text/css'> -->
	<link href="{{ asset('/css/bootstrap-table.css') }}" rel='stylesheet' type='text/css'>
	<link href="{{ asset('/css/jquery-ui.min.css') }}" rel='stylesheet' type='text/css'>
	<link href="{{ asset('/css/custom.css') }}" rel="stylesheet">


	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/') }}">FG Stock (Kikinda)</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/pallet') }}">Pallets</a></li>
				</ul>
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/cbstock') }}">Stock table</a></li>
				</ul>
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/cbship') }}">Ship table</a></li>
				</ul>
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/cbship_log') }}">Ship Log table</a></li>
				</ul>
				{{-- 
				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Login</a></li>
						<li><a href="{{ url('/auth/register') }}">Register</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
				--}}
			</div>
		</div>
	</nav>

	@yield('content')

	<!-- Scripts -->
	<script src="{{ asset('/js/jquery.min.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}" type="text/javascript" ></script>

    <script src="{{ asset('/js/bootstrap-table.js') }}" type="text/javascript" ></script>
	<script src="{{ asset('/js/jquery-ui.min.js') }}" type="text/javascript" ></script>

	<script src="{{ asset('/js/tableExport.js') }}" type="text/javascript" ></script>
	<script src="{{ asset('/js/FileSaver.min.js') }}" type="text/javascript" ></script>
	<script src="{{ asset('/js/bootstrap-table-export.js') }}" type="text/javascript" ></script>

        <script type="text/javascript">
	$(function() {
		$('#filter').keyup(function () {

	        var rex = new RegExp($(this).val(), 'i');
	        $('.searchable tr').hide();
	        $('.searchable tr').filter(function () {
	            return rex.test($(this).text());
	        }).show();
		});

	$(function () {
	var $table = $('.table');
		$('#toolbar').find('select').change(function () {
    		$table.bootstrapTable('refreshOptions', {
		      exportDataType: $(this).val()
    		});
  		});
	});

	$('#sort').bootstrapTable({
    
	});
	/*
    $('.session').keypress(function(event) {
  		if ( event.which == 13 ) {
     		event.preventDefault();
  		}
  		xTriggered++;
  		var msg = "Handler for .keypress() called " + xTriggered + " time(s).";
  		$.print( msg, "html" );
  		//$.print( event );
	});
	*/
	// $('#proba').keyup(function(e){
	// 	if(e.keyCode == 13) {
	// 		var bblist = $('#proba').val();
	//   		$("#display").append("<li>" + bblist + "</li>");

	//   		$('#proba').val('');

	//   		var optionTexts = [];
	// 		$("#display li").each(function() {
	// 			optionTexts.push($(this).text()) 
	// 		});

	// 		console.log(optionTexts);
	// 	}
	// });
	
	/*
	$("#proba").change(function() {
    	alert("Something happened!");
	});
		
	$('#proba').keyup(function () {
  		$('#display').text($(this).val());
	});
	*/
	//console.log("proba");

	});	
    </script>
</body>
</html>
