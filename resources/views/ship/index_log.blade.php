@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center">
            <div class="panel panel-default">
				<div class="panel-heading"><b>Shipment LOG</b> Table</div>
				
				<div class="input-group"> <span class="input-group-addon">Filter</span>
                    <input id="filter" type="text" class="form-control" placeholder="Type here...">
                </div>
                
                <table class="table table-striped table-bordered" id="sort" 
                data-show-export="true"
                data-export-types="['excel']"
                    
                >
                    <!--
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
    	                        <th>Cartonbox</th>
                                <th>Po</th>
                                <th>Style</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th>Pallet</th>
                                <th>Module/Line</th>
                                <th>Comment</th>
                                <th>Created</th>
                                <th>Updated</th>

    	                        
                                
                            </tr>
                        </thead>
                        <tbody class="searchable">
    			        @foreach ($cbs as $req)
                            <tr>
                                {{--<td>{{ $req->id }}</td>--}}
                                <td>{{ $req->cartonbox }}</td>
                                <td>{{ $req->po }}</td>
                                <td>{{ $req->style }}</td>
                                <td>{{ $req->color }}</td>
                                <td>{{ $req->size }}</td>
                                <td>{{ $req->qty }}</td>
                                <td>{{ $req->pallet }}</td>
                                <td>{{ $req->module }}</td>
                                <td>{{ $req->coment }}</td>
                                <td>{{ $req->created_at }}</td>
                                <td>{{ $req->updated_at }}</td>
                                
                            </tr>
                        @endforeach
                        
                        </tbody>
                </table>
			 </div>
		</div>
	</div>
</div>
@endsection