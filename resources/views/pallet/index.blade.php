@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-4 col-md-offset-4">
            <div class="panel panel-default">
				<div class="panel-heading">Pallet Table</div>
				
                
				<div class="panel-body">
					<div class="">
						<a href="{{url('/pallet_new')}}" class="btn btn-default btn-info">Add new Pallet</a>
                        <a href="{{url('/import')}}" class="btn btn-default btn-info">Import Pallets from Excel</a>
					</div>
				</div>
               
                
				<div class="input-group"> <span class="input-group-addon">Filter</span>
                    <input id="filter" type="text" class="form-control" placeholder="Type here...">
                </div>
                
                <table class="table table-striped table-bordered" id="sort" 
                >
                    <!--
                    data-show-export="true"
                    data-export-types="['excel']"
                    data-search="true"
                    data-show-refresh="true"
                    data-show-toggle="true"
                    data-query-params="queryParams" 
                    data-pagination="true"
                    data-height="300"
                    data-show-columns="true" 
                    data-export-options='{
                             "fileName": "preparation_app", 
                             "worksheetName": "test1",         
                             "jspdf": {                  
                               "autotable": {
                                 "styles": { "rowHeight": 20, "fontSize": 10 },
                                 "headerStyles": { "fillColor": 255, "textColor": 0 },
                                 "alternateRowStyles": { "fillColor": [60, 69, 79], "textColor": 255 }
                               }
                             }
                           }'
                    -->
                        <thead>
                        	<tr>
    	                        <!-- <td>Id</td> -->
    	                        <th>Pallet</th>
    	                        
    	                        
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="searchable">
    			        @foreach ($pallets as $req)
                            <tr>
                                {{--<td>{{ $req->id }}</td>--}}
                                <td>{{ $req->pallet }}</td>
                                
                                
                                
                                    <td><a href="{{ url('/pallet/edit/'.$req->id) }}" class="btn btn-info btn-xs center-block">Edit</a></td>
                                
                            </tr>
                        @endforeach
                        
                        </tbody>
                </table>
			 </div>
		</div>
	</div>
</div>
@endsection