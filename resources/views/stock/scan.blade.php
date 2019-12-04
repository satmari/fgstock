@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Add CB to Stock (pallet: {{ $pallet }})</div>
				
				@if(isset($msg))
				<h4 style="color:red;">{{ $msg }}</h4>
				@endif

				@if(isset($msg1))
				<h4 style="color:green;">{{ $msg1 }}</h4>
				@endif
							
				{!! Form::open(['url' => 'scanncb']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				
				{!! Form::hidden('pallet', $pallet) !!}

				<div class="panel-body">
					{!! Form::input('number', 'cb_to_add', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
				</div>
				
				<div class="panel-body">
					{!! Form::submit('Confirm box', ['class' => 'btn btn-danger btn-lg center-block']) !!} 
				</div>
				
				@include('errors.list')
				{!! Form::close() !!}
				<hr>

				
				@if(isset($cbaddarray_unique))
					<table class="table">
						<thead>
							<td>CB name</td>
							<td>CB qty</td>
						</thead>

					@foreach($cbaddarray_unique as $array)
						<tr>
							<td>
							@foreach($array as $key => $value)
								@if($key == 'cartonbox')
						    		{{ $value }}
						    	@endif
						    @endforeach
					   		</td>
					   		<td>
					   		
							@foreach($array as $key => $value)
								@if($key == 'qty')
						    		{{ $value }}
						    	@endif
						    @endforeach
						    
					   		</td>
					    </tr>

					@endforeach

						<tfoot>
						{{-- 
						<tr>
							<td>
								Total:
							</td>
					   		<td>
							<big><b>{{ $sumofbb }}</b></big>
					   		</td>
					    </tr>
					    --}}
						</tfoot>
					</table>
				@endif

				{!! Form::open(['url' => 'scannlist']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				{!! Form::hidden('pallet', $pallet) !!}
				
				<div class="panel-body">
					{!! Form::submit('Confirm list', ['class' => 'btn btn-danger btn-lg center-block']) !!}
				</div>

				@include('errors.list')

				{!! Form::close() !!}

				<br>
				<div class="">
						<a href="{{url('/')}}" class="btn btn-default btn-lg center-block">Back to main menu</a>
				</div>

			</div>
		</div>
	</div>
</div>
@endsection