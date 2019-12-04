@extends('app')

@section('content')
<div class="container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Post Shipment:</div>
				<br>
					<p>Do you want to post Shipment and remove all boxes from shipment table?</p>
					{!! Form::open(['method'=>'POST', 'url'=>'confirm_shipment']) !!}
					{!! Form::submit('Confirm', ['class' => 'btn  btn-danger center-block']) !!}
					{!! Form::close() !!}
					
				<hr>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/cbship')}}" class="btn btn-default">Back</a>
					</div>
				</div>
					
			</div>
		</div>
	</div>
</div>

@endsection