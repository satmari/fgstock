<?php namespace App\Http\Controllers;

// use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
// use Request;
use Illuminate\Support\Facades\Redirect;

use Maatwebsite\Excel\Facades\Excel;

use App\pallet;
use App\cbstock;
use App\cbship;
use DB;

use Log;
use Session;


class shipController extends Controller {


	public function index()
	{
		//
		try {
			$cbs = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM cbships ORDER BY created_at desc"));
		}
		catch (\Illuminate\Database\QueryException $e) {
			$cbs = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM cbships ORDER BY created_at desc"));
			return view('ship.index', compact('cbs'));
		}

		return view('ship.index', compact('cbs'));
	}

	public function scan_to_shipment()
	{	
		//
		Session::set('cb_to_add_array', null);
		return view('ship.scan');
	}

	public function scanncb(Request $request)
	{
		// $this->validate($request, ['cb_to_add'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; 
		// dd($input);

		if 	($input['cb_to_add']){

			$cb_to_add = $input['cb_to_add'];

			$local_ship = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM cbships WHERE cartonbox = :somevariable"), array(
				'somevariable' => $cb_to_add,
			));

			if ($local_ship) {
				$cbaddarray = Session::get('cb_to_add_array');
				if ($cbaddarray != null) {
					$cbaddarray_unique = array_map("unserialize", array_unique(array_map("serialize", $cbaddarray)));	
				} 

				$msg = "Box is already in shipment";
				return view('ship.scan', compact('msg', 'cbaddarray_unique'));
			}		

			$local = DB::connection('sqlsrv')->select(DB::raw("SELECT id, cartonbox, qty FROM cbstocks WHERE cartonbox = :somevariable"), array(
				'somevariable' => $cb_to_add,
			));

			if ($local) {
				// continue
				// dd($local);

				function object_to_array($data)
				{
				    if (is_array($data) || is_object($data))
				    {
				        $result = array();
				        foreach ($data as $key => $value)
				        {
				            $result[$key] = object_to_array($value);
				        }
				        return $result;
				    }
				    return $data;
				}
			
		    	$local_array = object_to_array($local);
		    	// dd($inteos_array);

				$cbaddarray = array(
				'cartonbox' => $local_array[0]['cartonbox'],
				'qty' => $local_array[0]['qty'],
				);
				
				Session::push('cb_to_add_array',$cbaddarray);
				$msg1 = 'Scanned Ok (cb exist on stock)';

			} else {

				if ((substr($cb_to_add, 0, 2) == '70') OR (substr($cb_to_add, 0, 2) == '84')) {

					$inteos = DB::connection('sqlsrv1')->select(DB::raw("SELECT [INTKEY],[BoxNum],[Produced] FROM [BdkCLZG].[dbo].[CNF_CartonBox] WHERE [BoxNum] = :somevariable"), array(
						'somevariable' => $cb_to_add,
					));
				
				} else if ((substr($cb_to_add, 0, 2) == '71') OR (substr($cb_to_add, 0, 2) == '85')) { 

					$inteos = DB::connection('sqlsrv5')->select(DB::raw("SELECT [INTKEY],[BoxNum],[Produced] FROM [BdkCLZKKA].[dbo].[CNF_CartonBox] WHERE [BoxNum] = :somevariable"), array('somevariable' => $cb_to_add));

	            } else {
			    	dd('Cannot find CB in ANY Inteos, NE POSTOJI KARTONSKA KUTIJA U NIJEDNOM INTEOSU !');
			    }

				if ($inteos) {
					//continue
					// dd($inteos);
				} else {

					$cbaddarray = Session::get('cb_to_add_array');
					if ($cbaddarray != null) {
						$cbaddarray_unique = array_map("unserialize", array_unique(array_map("serialize", $cbaddarray)));	
					} 
					
					$msg = "Carton box not exist";
					return view('ship.scan', compact('msg','cbaddarray_unique'));
				}

				function object_to_array($data)
				{
				    if (is_array($data) || is_object($data))
				    {
				        $result = array();
				        foreach ($data as $key => $value)
				        {
				            $result[$key] = object_to_array($value);
				        }
				        return $result;
				    }
				    return $data;
				}
			
		    	$inteos_array = object_to_array($inteos);
		    	// dd($inteos_array);

				$cbaddarray = array(
				'cartonbox' => $inteos_array[0]['BoxNum'],
				'qty' => $inteos_array[0]['Produced'],
				);
				
				Session::push('cb_to_add_array',$cbaddarray);
				$msg1 = 'Scanned Ok (cb not exist on stock)';
			}
		}
		

		$cbaddarray = Session::get('cb_to_add_array');
		// dd($cbaddarray);

		if ($cbaddarray != null) {

			$cbaddarray_unique = array_map("unserialize", array_unique(array_map("serialize", $cbaddarray)));
			// Session::push('bb_to_add_array',$bbaddarray_unique); // dodato sada
		}

		// dd($cbaddarray_unique);
		
		return view('ship.scan', compact('cbaddarray_unique','msg1'));
	}

	public function scannlist(Request $request)
	{	
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// var_dump($input);

		// $pallet = $input['pallet'];

		/*
		if (isset($input['cbaddarray_unique'])) {
			$cbaddarray_unique = $input['cbaddarray_unique'];	
			dd("U: ".$cbaddarray_unique);
		}
		*/

		$cbaddarray = Session::get('cb_to_add_array');
		// Session::set('cb_to_add_array', null);

		if ($cbaddarray != null) {
			$cbaddarray_unique = array_map("unserialize", array_unique(array_map("serialize", $cbaddarray)));
		
			foreach ($cbaddarray_unique as $line) {

				// dd($line['cartonbox']);



				try {
					$local = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM cbstocks WHERE cartonbox = '".$line['cartonbox']."' "));
				} catch (\Illuminate\Database\QueryException $e) {
					$local = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM cbstocks WHERE cartonbox = '".$line['cartonbox']."' "));
				}

				// dd($cb);

				if ($local) {
					// dd("yes");

					$cartonbox = $local[0]->cartonbox;
					$qty = $local[0]->qty;
					$standard_qty = $local[0]->standard_qty;
					$boxclosed = $local[0]->boxclosed;
					$po = $local[0]->po;
					$style = $local[0]->style;

					if (isset($local[0]->module)) {
						$module = $local[0]->module;
					} else {
						$module = NULL;
					}
					// $variant = $local[0]->variant;
					$color = $local[0]->color;
					$size = $local[0]->size;
					$pallet = $local[0]->pallet;
					$coment = $local[0]->coment;
					
					try {
						$cbShip = new cbship;

						$cbShip->cartonbox = $cartonbox;
						$cbShip->po = $po;
						$cbShip->style = $style;
						$cbShip->color = $color;
						$cbShip->size = $size;
						$cbShip->qty = $qty;
						$cbShip->standard_qty = $standard_qty;
						$cbShip->boxclosed = $boxclosed;
						$cbShip->module = $module;
						$cbShip->pallet = $pallet;
						$cbShip->coment = $coment;
						
						$cbShip->save();
					}
					catch (\Illuminate\Database\QueryException $e) {
						dd("Problem to save in table ship");
					}

					$cb = cbstock::findOrFail($local[0]->id);
					$cb->delete();

				} else {
					// dd("no");

					if ((substr($line['cartonbox'], 0, 2) == '70') OR (substr($line['cartonbox'], 0, 2) == '84')) {

						$inteos = DB::connection('sqlsrv1')->select(DB::raw("SELECT	cb.[BoxNum] as cartonbox,
										cb.[Produced] as qty,
										cb.[BoxQuant] as standard_qty,
										cb.[EDITDATE] as boxclosed,
										po.[POnum] as po,
										sku.[Variant] as variant,
										st.[StyCod] as style,
										m.[ModNam] as module
								FROM [BdkCLZG].[dbo].[CNF_CartonBox] as cb
								JOIN [BdkCLZG].[dbo].[CNF_PO] as po ON cb.[IntKeyPO] = po.[INTKEY]
								JOIN [BdkCLZG].[dbo].[CNF_SKU] as sku ON po.[SKUKEY] = sku.[INTKEY]
								JOIN [BdkCLZG].[dbo].[CNF_STYLE] as st ON sku.[STYKEY] = st.[INTKEY]
								LEFT JOIN [BdkCLZG].[dbo].[CNF_Modules] as m ON cb.[Module] = m.[Module]
								WHERE BoxNum = :somevariable"), array(
							'somevariable' => $line['cartonbox'],
						));
						// dd($inteos);

					} elseif ((substr($line['cartonbox'], 0, 2) == '71') OR (substr($line['cartonbox'], 0, 2) == '85')) {

						$inteos = DB::connection('sqlsrv5')->select(DB::raw("SELECT	cb.[BoxNum] as cartonbox,
										cb.[Produced] as qty,
										cb.[BoxQuant] as standard_qty,
										cb.[EDITDATE] as boxclosed,
										po.[POnum] as po,
										sku.[Variant] as variant,
										st.[StyCod] as style,
										m.[ModNam] as module
								FROM [BdkCLZKKA].[dbo].[CNF_CartonBox] as cb
								JOIN [BdkCLZKKA].[dbo].[CNF_PO] as po ON cb.[IntKeyPO] = po.[INTKEY]
								JOIN [BdkCLZKKA].[dbo].[CNF_SKU] as sku ON po.[SKUKEY] = sku.[INTKEY]
								JOIN [BdkCLZKKA].[dbo].[CNF_STYLE] as st ON sku.[STYKEY] = st.[INTKEY]
								LEFT JOIN [BdkCLZKKA].[dbo].[CNF_Modules] as m ON cb.[Module] = m.[Module]
								WHERE BoxNum = :somevariable"), array(
							'somevariable' => $line['cartonbox'],
						));
						// dd($inteos);

					} else {

				    	dd('Cannot find CB in ANY Inteos, NE POSTOJI KARTONSKA KUTIJA U NIJEDNOM INTEOSU !');
				    }

					$cartonbox = $inteos[0]->cartonbox;

					if (isset($inteos[0]->qty)) {
						$qty = $inteos[0]->qty;	
					} else {
						$qty = 0;
					}
					
					$standard_qty = $inteos[0]->standard_qty;
					$boxclosed = $inteos[0]->boxclosed;
					$po = $inteos[0]->po;
					$style = $inteos[0]->style;

					if (isset($inteos[0]->module)) {
						$module = $inteos[0]->module;
					} else {
						$module = NULL;
					}

					$variant = $inteos[0]->variant;

					$brlinija = substr_count($variant,"-");
					// echo $brlinija." ";

					if ($brlinija == 2)
					{
						list($color, $size1, $size2) = explode('-', $variant);
						$size = $size1."-".$size2;
						// echo $color." ".$size;	
					} else {
						list($color, $size) = explode('-', $variant);
						// echo $color." ".$size;
					}

					try {
						$cbStock = new cbship;

						$cbStock->cartonbox = $cartonbox;
						$cbStock->po = $po;
						$cbStock->style = $style;
						$cbStock->color = $color;
						$cbStock->size = $size;
						$cbStock->qty = $qty;
						$cbStock->standard_qty = $standard_qty;
						$cbStock->boxclosed = $boxclosed;
						$cbStock->module = $module;

						$cbStock->pallet = NULL;
						
						$cbStock->save();
					}
					catch (\Illuminate\Database\QueryException $e) {
						dd("Problem to save in table ship");
					}
				}
			}
			//nest cb
			//dd($cbaddarray_unique);
		}
		return Redirect::to('/cbship');
	}

	public function edit($id) {

		$cb = cbship::findOrFail($id);
		$pallets = pallet::orderBy('id')->lists('pallet','pallet');

		return view('ship.edit', compact('cb','pallets'));
	}

	public function update($id, Request $request) {
		//
		$this->validate($request, ['qty'=>'required', 'pallet'=>'required']);

		$cb = cbship::findOrFail($id);		
		$input = $request->all();

		try {
			$cb->qty = $input['qty'];
			$cb->pallet = $input['pallet'];
			$cb->coment = $input['coment'];
			$cb->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			return view('ship.error');
		}
		
		return Redirect::to('/cbship');
	}

	public function delete($id) {

		$cb = cbship::findOrFail($id);
		$cb->delete();

		return Redirect::to('/cbship');
	}

	public function post_shipment() {

		return view('ship.post_shipment');
	}

	public function confirm_shipment() {

		$da = date("Y-m-d H:i:s");

		$sql = DB::connection('sqlsrv')->select(DB::raw("SET NOCOUNT ON;
				INSERT INTO [cbStock].[dbo].[cbship_logs]
			           ([cartonbox]
			           ,[po]
			           ,[style]
			           ,[color]
			           ,[size]
			           ,[qty]
			           ,[standard_qty]
			           ,[boxclosed]
			           ,[module]
			           ,[pallet]
			           ,[coment]
			           ,[created_at]
					   ,[updated_at])
			 	SELECT 
					   [cartonbox]
			           ,[po]
			           ,[style]
			           ,[color]
			           ,[size]
			           ,[qty]
			           ,[standard_qty]
			           ,[boxclosed]
			           ,[module]
			           ,[pallet]
			           ,[coment]
			           ,[created_at]
					   ,'".$da."'

			 FROM [cbStock].[dbo].[cbships]
			 TRUNCATE TABLE [cbStock].[dbo].[cbships];
			 SELECT TOP 1 [id] FROM [cbStock].[dbo].[cbships];
			"));

		return Redirect::to('/cbship');
	}

	public function index_log()
	{
		//
		try {
			$cbs = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM cbship_logs ORDER BY created_at desc"));
		}
		catch (\Illuminate\Database\QueryException $e) {
			$cbs = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM cbship_logs ORDER BY created_at desc"));
			return view('ship.index_log', compact('cbs'));
		}

		return view('ship.index_log', compact('cbs'));
	}

}
