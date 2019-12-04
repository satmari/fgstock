@extends('app')

@section('content')
<div class="container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Edit Cartonbox:</div>
				<br>
					{!! Form::model($cb , ['method' => 'POST', 'url' => 'cb_ship/'.$cb->id /*, 'class' => 'form-inline'*/]) !!}

					<div class="panel-body">
						<span>Qty : <span style="color:red;">*</span></span>
						{!! Form::input('number', 'qty', $cb->qty, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
					</div>

					<div class="panel-body">
						<span>Pallet : <span style="color:red;">*</span></span>
    					{!! Form::select('pallet', ['' => ''] + $pallets, $cb->pallet,['class' => 'form-control']) !!}
	   				</div>

	   				<div class="panel-body">
						<span>Comment : </span>
    					{!! Form::input('text', 'coment', $cb->coment, ['class' => 'form-control']) !!}
	   				</div>
					
					
					<div class="panel-body">
						{!! Form::submit('Save', ['class' => 'btn btn-success center-block']) !!}
					</div>

					@include('errors.list')

					{!! Form::close() !!}
					<br>
					
					{!! Form::open(['method'=>'POST', 'url'=>'/cb_ship/delete/'.$cb->id]) !!}
					{!! Form::hidden('id', $cb->id, ['class' => 'form-control']) !!}
					{!! Form::submit('Delete', ['class' => 'btn  btn-danger btn-xs center-block']) !!}
					{!! Form::close() !!}
					
				<hr>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/cbstock')}}" class="btn btn-default">Back</a>
					</div>
				</div>
					
			</div>
		</div>
	</div>
</div>

@endsection