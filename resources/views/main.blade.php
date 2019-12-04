@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">Main page</div>

				<div class="panel-body">
					<div class="panel-body">
						<div class="">
							<a href="{{url('/add_to_stock')}}" class="btn btn-success btn-lg center-block"><br>Add CB to Stock<br><br></a>
						</div>
					</div>
					<div class="panel-body">
						<div class="">
							<a href="{{url('/scan_to_shipment')}}" class="btn btn-info btn-lg center-block"><br>Add CB to Shipment<br><br></a>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
@endsection
