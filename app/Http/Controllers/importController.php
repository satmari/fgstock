<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

// use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

use Request;

use App\pallet;
use App\sell_rm;

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
	                	/*
						$userbulk = new pallet;
						$userbulk->pallet = $row['pallet'];
						$userbulk->save();
						*/
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

	public function postImport_sellrm1(Request $request) {
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



	                	//dd($row['item']);
	                	//dd($row['variant']);
						

	                	/*
	                	$sql = DB::connection('sqlsrv2')->select(DB::raw("SELECT
							      [Item No_] as item
							      ,[Variant Code] as variant
							      ,[Remaining Quantity] as qty
							      ,[Entry No_] as applay
							 FROM [Gordon_LIVE].[dbo].[GORDON\$Item Ledger Entry]
							 WHERE [Remaining Quantity] > 0 and [Location Code] = 'GORD ROW M' and [Item No_] = '".$row['item']."' and [Variant Code] = '".$row['variant']."'
					   "));
						
						// dd($sql);

						for ($i=0; $i < count($sql); $i++) { 
							// dd($sql[$i]->qty);


							$userbulk = new sell_rm;
							$userbulk->item = $row['item'];
							$userbulk->variant = $row['variant'];
							$userbulk->qty = (double)$sql[$i]->qty;
							$userbulk->applay = $sql[$i]->applay;

							$userbulk->save();
							

						}
						*/

	                }
	            });
	    }
		return redirect('/');
	}

	public function postImport_sellrm(Request $request) {
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


	                	// dd($row);
	                	// dd($row['bb']);
	                	// dd($row['R']);
						
	                	// za stavljanje lokacije_odgovornog u OS
	                	/*
	                	$sql = DB::connection('sqlsrv2')->select(DB::raw("SET NOCOUNT ON;
	                		UPDATE [Gordon_LIVE].[dbo].[GORDON\$Fixed Asset]
							SET [FA Location Code] = '".$row['r']."'
							WHERE [No_] = '".$row['fa']."';
							SELECT TOP 1 [No_] FROM [Gordon_LIVE].[dbo].[GORDON\$Fixed Asset]
					   "));
					   */

						/*
						// za dodavanje FA klase OS
	                	// dd($row);
	                	$sql = DB::connection('sqlsrv2')->select(DB::raw("SET NOCOUNT ON;
	                		UPDATE [Gordon_LIVE].[dbo].[GORDON\$Fixed Asset]
							SET [SAP Class code] = '".$row['r']."'
							WHERE [No_] = '".$row['fa']."';
							SELECT TOP 1 [No_] FROM [Gordon_LIVE].[dbo].[GORDON\$Fixed Asset]
					   "));
					   */

						/*
						// za dodavanje CC u OS
	                	// dd($row);
	                	$sql = DB::connection('sqlsrv2')->select(DB::raw("SET NOCOUNT ON;
	                		UPDATE [Gordon_LIVE].[dbo].[GORDON\$Fixed Asset]
							SET [Global Dimension 1 Code] = '".$row['cc']."'
							WHERE [No_] = '".$row['os']."';
							SELECT TOP 1 [No_] FROM [Gordon_LIVE].[dbo].[GORDON\$Fixed Asset]
					   "));
						*/
						/*
	                	// za dodavanje CC u OS 2 
	                	// dd($row);
	                	$sql = DB::connection('sqlsrv2')->select(DB::raw("SET NOCOUNT ON;
	                		UPDATE [Gordon_LIVE].[dbo].[GORDON\$Default Dimension]
							SET [Dimension Value Code] = '".$row['cc']."'
							WHERE [Table ID] = '5600' and [Dimension Code] = 'CC' and [No_] = '".$row['os']."';
							SELECT TOP 1 [No_] FROM [Gordon_LIVE].[dbo].[GORDON\$Fixed Asset]
					   "));
					   */
	            		
	            		//-----------------------
	            		// dd($row);
	            		// za stavljnje status Complited Subotica
			            // dd($row);
						
						/*
	                	$sql = DB::connection('sqlsrv1')->select(DB::raw("SET NOCOUNT ON;
	                		UPDATE [BdkCLZG].[dbo].[CNF_BlueBox] 
							SET [Status] = '99'
							WHERE [BlueBoxNum] = '".$row['bb']."';
							SELECT TOP 1 [BlueBoxNum] FROM [BdkCLZG].[dbo].[CNF_BlueBox]
					   "));
					   */

	                	//Kikinda
						/*
	                	$sql = DB::connection('sqlsrv1')->select(DB::raw("SET NOCOUNT ON;
	                		UPDATE [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_BlueBox]
							SET [Status] = '99'
							WHERE [BlueBoxNum] = '".$row['bb']."';
							SELECT TOP 1 [BlueBoxNum] FROM [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_BlueBox]
					   "));
					   */
					   //-------------------------

						// dd($row['bb']);
	                	// za automatsko skeniranje rolni
						/*
	                	$sql = DB::connection('sqlsrv2')->select(DB::raw("SET NOCOUNT ON;
	                		  UPDATE [Gordon_LIVE].[dbo].[GORDON\$WMS Scanned Line]
  							  SET [ScannedYes] = '1' , [ScannedCount] = '1'
  							  WHERE [Document Type] = '1' and [Document No_] = 'HU' and [Barcode No_] = '".$row['bb']."';
							  SELECT TOP 1 [Entry No_] FROM [Gordon_LIVE].[dbo].[GORDON\$WMS Scanned Line]
					   "));
					   */

						// dd($row['item']);
						// dd($row['sapvc']);
	                	// za inport SAP valuation class u Item (Fiorano)
						/*
	                	$sql = DB::connection('sqlsrv3')->select(DB::raw("SET NOCOUNT ON;
	                		  UPDATE [Fiorano_LIVE].[dbo].[Fiorano_live_company\$Item]
								SET [SAP VAluation Class] = 'WR04'
								WHERE [No_] = 'FLFIL1';
							  SELECT TOP 1 [No_] FROM [Fiorano_LIVE].[dbo].[Fiorano_live_company\$Item];
					   "));
					   */

						// dd($row['item']);
						// dd($row['sapvc']);
	                	// za inport SAP valuation class u Item (Gordon)
						/*
	                	$sql = DB::connection('sqlsrv2')->select(DB::raw("SET NOCOUNT ON;
	                		  UPDATE [Gordon_LIVE].[dbo].[GORDON\$Item]
								SET [SAP VAluation Class] = '".$row['sapvc']."'
								WHERE [No_] = '".$row['item']."';
							  SELECT TOP 1 [No_] FROM [Gordon_LIVE].[dbo].[GORDON\$Item];
					   "));
					   */


						/*
						// dd($row['k']);
	                	$sql = DB::connection('sqlsrv1')->select(DB::raw("SET NOCOUNT ON;
	                		UPDATE [BdkCLZG].[dbo].[CNF_PO]
							SET [POClosed] = '1'
							WHERE [POnum] = '".$row['k']."';
							SELECT TOP 1 [BlueBoxNum] FROM [BdkCLZG].[dbo].[CNF_BlueBox]
					   "));
					   */

						
						
						// dd($row['os']);
						// dd($row['location']);
						// dd($row['pos']);
						
		
		/*	Inteos Machines 

						$machine =  DB::connection('sqlsrv1')->select(DB::raw("SELECT mp.*
						      ,mm.*
						      ,mt.*
						  FROM [BdkCLZG].[dbo].[CNF_MachPool] mp
						  LEFT JOIN [BdkCLZG].[dbo].CNF_ModMach as mm ON mp.Cod = mm.MdCod
						  LEFT JOIN [BdkCLZG].[dbo].CNF_MaTypes as mt ON mt.IntKey = mp.MaTyCod
						  where MachNum = '".$row['os']."' "));
						// dd($machine[0]);
						var_dump($machine[0]->MachNum);

						
						//SET Active in Subotica
						 $sql = DB::connection('sqlsrv1')->select(DB::raw("SET NOCOUNT ON;
						 	UPDATE [BdkCLZG].[dbo].[CNF_MachPool]
  							SET NotAct = NULL, InRepair = '2020-09-13 07:00:00.000'
  							WHERE Cod = '".$machine[0]->Cod."'
  							SELECT TOP 1 [BlueBoxNum] FROM [BdkCLZG].[dbo].[CNF_BlueBox]"));
  
  						//SET not active in Kikinda
  						 $sql1 = DB::connection('sqlsrv1')->select(DB::raw("SET NOCOUNT ON;
  							UPDATE [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_MachPool]
  							SET NotAct = '1'
  							WHERE Cod = '".$machine[0]->Cod."'	
  							SELECT TOP 1 [BlueBoxNum] FROM [BdkCLZG].[dbo].[CNF_BlueBox]"));
						

  						//CHECK module/location
  						 $sql2 = DB::connection('sqlsrv1')->select(DB::raw("
							SELECT [Module],[ModNam]
							FROM [BdkCLZG].[dbo].[CNF_Modules]
							WHERE [ModNam] = '".$row['location']."' "));
  						 // dd($sql2[0]->Module);
  						 // var_dump($sql2[]->)
						
						
						
						//FIND FIRST NULL POSITION
  						 $sql3 = DB::connection('sqlsrv1')->select(DB::raw("
							SELECT TOP 1 Pos
							FROM [BdkCLZG].[dbo].[CNF_ModMach]
							WHERE Module = '".$sql2[0]->Module."' AND MdCod is NULL
							"));
  						 // dd($sql3[0]->Pos);
  						 // var_dump($sql3[0]->Pos);
  						 

  						 
  						 //UPDATE location and pos //REMOVE OLD
  						  $sql = DB::connection('sqlsrv1')->select(DB::raw("SET NOCOUNT ON;
						 	UPDATE [BdkCLZG].[dbo].[CNF_ModMach]
						  	SET MdCod = NULL, [MaStat] = NULL
						  	WHERE Module = '".$machine[0]->Module."' AND Pos = '".$machine[0]->Pos."'
  							SELECT TOP 1 [BlueBoxNum] FROM [BdkCLZG].[dbo].[CNF_BlueBox]"));

  						 //UPDATE location and pos //SET NEW
  						  $sql = DB::connection('sqlsrv1')->select(DB::raw("SET NOCOUNT ON;
						 	UPDATE [BdkCLZG].[dbo].[CNF_ModMach]
						  	SET MdCod = '".$machine[0]->Cod."', [MaStat] = NULL
						  	WHERE Module = '".$sql2[0]->Module."' AND Pos = '".$sql3[0]->Pos."'
  							SELECT TOP 1 [BlueBoxNum] FROM [BdkCLZG].[dbo].[CNF_BlueBox]"));
			*/	

						
						/*
						// SET MASHINE TO REPAIR
						//REMOVE location and pos FROR REPAIR machines
  						  $sql = DB::connection('sqlsrv1')->select(DB::raw("SET NOCOUNT ON;
						 	UPDATE [BdkCLZG].[dbo].[CNF_ModMach]
						  	SET MdCod = NULL, [MaStat] = NULL
						  	WHERE MdCod = '".$machine[0]->Cod."'
  							SELECT TOP 1 [BlueBoxNum] FROM [BdkCLZG].[dbo].[CNF_BlueBox]"));
						*/

						 // ModMach table 
  						 // [MaStat] = NULL
  						  			// MachPool table == 
  						 			// In Reparir = NOTNULL ([InRepair])
  						 			// Available = NULL ([InRepair])

  						 // [MaStat] = Spare = 0
  						 // [MaStat] = Needed = 1
  						 // [MaStat] = Ready for next chenge = 4
  						 // [MaStat] = On Stock = 5
  						 // [MaStat] = To be repaired = 6

  						 
						
	                }
	            });
	    }
		// return redirect('/');
		// dd('Restricted zone, call IT');
	}

	

}

/*

SELECT
      [Item No_]
      ,[Variant Code]
      ,[Location Code]
      ,[Global Dimension 1 Code] as CC
      ,[Remaining Quantity] as Qty
      ,[Remaining Quantity] as QtyShip
      ,[Remaining Quantity] as QtyInv
      ,[Entry No_] as Applay_to_entry
 

  FROM [Gordon_LIVE].[dbo].[GORDON$Item Ledger Entry]
  WHERE [Item No_] = 'AF0129' and [Variant Code] = '0999-001' and [Remaining Quantity] > 0 
  ORDER BY [GORDON$Item Ledger Entry].[Global Dimension 2 Code] asc

  */