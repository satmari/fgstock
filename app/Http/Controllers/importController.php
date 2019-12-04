<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

// use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

use Request;

use App\pallet;
// use App\role_user;
use DB;

class importController extends Controller {

		public function index()
	{
		//
		return view('import.index');
	}

	public function postImportpallet(Request $request) {
	    $getSheetName = Excel::load(Request::file('file'))->getSheetNames();
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            //DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file'))->chunk(50, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                //var_dump($readerarray);

	                foreach($readerarray as $row)
	                {

						$userbulk = new pallet;
						$userbulk->pallet = $row['pallet'];
						$userbulk->save();

	                	// dd($row['pallet']);
						
						/*
						$sql = DB::connection('sqlsrv1')->select(DB::raw("SET NOCOUNT ON;
								UPDATE [BdkCLZG].[dbo].[CNF_PO]
								SET [POClosed] = 1
								WHERE [POnum] = '".$row['pallet']."' ;
						 		SELECT TOP 1 [POnum] FROM [BdkCLZG].[dbo].[CNF_PO];
						"));
						*/



	                }
	            });
	    }
		return redirect('/');
	}

	

}
