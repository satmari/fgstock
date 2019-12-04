@extends('app')

@section('content')
<div class="container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Edit Pallet:</div>
				<br>
					{!! Form::model($pallet , ['method' => 'POST', 'url' => 'pallet/'.$pallet->id /*, 'class' => 'form-inline'*/]) !!}

					
					<div class="panel-body">
						<span>Pallet : <span style="color:red;">*</span></span>
						{!! Form::input('string', 'pallet', null, ['class' => 'form-control']) !!}
					</div>
					
					<div class="panel-body">
						{!! Form::submit('Save', ['class' => 'btn btn-success center-block']) !!}
					</div>

					@include('errors.list')

					{!! Form::close() !!}
					<br>
					
					{!! Form::open(['method'=>'POST', 'url'=>'/pallet/delete/'.$pallet->id]) !!}
					{!! Form::hidden('id', $pallet->id, ['class' => 'form-control']) !!}
					{!! Form::submit('Delete', ['class' => 'btn  btn-danger btn-xs center-block']) !!}
					{!! Form::close() !!}
					
				<hr>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/pallet')}}" class="btn btn-default">Back</a>
					</div>
				</div>
					
			</div>
		</div>
	</div>
</div>

@endsection