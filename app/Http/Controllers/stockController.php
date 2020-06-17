<?php namespace App\Http\Controllers;

// use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
// use Request;
use Illuminate\Support\Facades\Redirect;

use Maatwebsite\Excel\Facades\Excel;

use App\pallet;
use App\cbstock;
use DB;

use Log;
use Session;

class stockController extends Controller {

	public function index()
	{
		//
		try {
			$cbs = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM cbstocks ORDER BY created_at desc"));
		}
		catch (\Illuminate\Database\QueryException $e) {
			$cbs = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM cbstocks ORDER BY created_at desc"));
			return view('stock.index', compact('cbs'));
		}

		return view('stock.index', compact('cbs'));
	}

	public function add_to_stock() 
	{	


		$pallets = pallet::orderBy('id')->lists('pallet','pallet');
		return view('stock.add_to_stock', compact('pallets'));

	}

	public function select_pallet(Request $request)
	{	
		$this->validate($request, ['pallet'=>'required']);
		$pallet_input = $request->all(); // change use (delete or comment user Requestl; )
		
		$pallet = $pallet_input['pallet'];

		if ($pallet == '') {
			dd("Pallet must be selected");
			// $msg = "Pallet must be selected";
			// return view('stock.add_to_stock', compact('pallets','msg'));
			// dd("None");
		}
		
		// dd($pallet);
		Session::set('cb_to_add_array', null);
		return view('stock.scan', compact('pallet'));
	}

	public function scanncb(Request $request)
	{
		$this->validate($request, ['pallet'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; 
		// dd($input);

		$pallet = $input['pallet'];		
		

		if 	($input['cb_to_add']){

			$cb_to_add = $input['cb_to_add'];

			if (substr($cb_to_add, 0, 2) == '70') {

				$inteos = DB::connection('sqlsrv1')->select(DB::raw("SELECT [INTKEY],[BoxNum],[Produced] FROM [BdkCLZG].[dbo].[CNF_CartonBox] WHERE [BoxNum] = :somevariable"), array(
					'somevariable' => $cb_to_add,
				));
			
			} elseif (substr($cb_to_add, 0, 2) == '71') {

				$inteos = DB::connection('sqlsrv5')->select(DB::raw("SELECT [INTKEY],[BoxNum],[Produced] FROM [BdkCLZKKA].[dbo].[CNF_CartonBox] WHERE [BoxNum] = :somevariable"), array(
					'somevariable' => $cb_to_add,
				));

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
				return view('stock.scan', compact('pallet','msg','cbaddarray_unique'));
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
			$msg1 = 'Scanned Ok';

		}

		$cbaddarray = Session::get('cb_to_add_array');
		// dd($cbaddarray);

		if ($cbaddarray != null) {
			$cbaddarray_unique = array_map("unserialize", array_unique(array_map("serialize", $cbaddarray)));
		}

		// dd($cbaddarray_unique);
		
		return view('stock.scan', compact('pallet','cbaddarray_unique','msg1'));
	}

	public function scannlist(Request $request)
	{	
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// var_dump($input);

		$pallet = $input['pallet'];

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
				$cb = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM cbstocks WHERE cartonbox = '".$line['cartonbox']."' "));
				// dd($cb);

				if ($cb) {
					// dd("yes");
				} else {
					// dd("no");

					if (substr($line['cartonbox'], 0, 2) == '70') {

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
					
					} elseif (substr($line['cartonbox'], 0, 2) == '71') {

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

					// try {
						$cbStock = new cbstock;

						$cbStock->cartonbox = $cartonbox;
						$cbStock->po = $po;
						$cbStock->style = $style;
						$cbStock->color = $color;
						$cbStock->size = $size;
						$cbStock->qty = $qty;
						$cbStock->standard_qty = $standard_qty;
						$cbStock->boxclosed = $boxclosed;
						$cbStock->module = $module;

						$cbStock->pallet = $pallet;
						
						$cbStock->save();
					// }
					// catch (\Illuminate\Database\QueryException $e) {
					// }
				}
			}
			// dd($cbaddarray_unique);			
		}


		return Redirect::to('/cbstock');
	}

	public function edit($id) {

		$cb = cbstock::findOrFail($id);
		$pallets = pallet::orderBy('id')->lists('pallet','pallet');

		return view('stock.edit', compact('cb','pallets'));
	}

	public function update($id, Request $request) {
		//
		$this->validate($request, ['qty'=>'required', 'pallet'=>'required']);

		$cb = cbstock::findOrFail($id);		
		$input = $request->all();

		try {
			$cb->qty = $input['qty'];
			$cb->pallet = $input['pallet'];
			$cb->coment = $input['coment'];
			$cb->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			return view('stock.error');
		}
		
		return Redirect::to('/cbstock');
	}

	public function delete($id) {

		$cb = cbstock::findOrFail($id);
		$cb->delete();

		return Redirect::to('/cbstock');
	}

	
}
