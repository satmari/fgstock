<?php namespace App\Http\Controllers;

// use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
// use Request;
use Illuminate\Support\Facades\Redirect;

use Maatwebsite\Excel\Facades\Excel;

use App\pallet;
use DB;

class palletController extends Controller {

	public function index()
	{
		//
		$pallets = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM pallets "));
		return view('pallet.index', compact('pallets'));
	}

	public function create()
	{
		//
		return view('pallet.create');
	}

	public function insert(Request $request)
	{
		//
		$this->validate($request, ['pallet'=>'required']);

		$pallet_input = $request->all(); // change use (delete or comment user Requestl; )
		
		$pallet = $pallet_input['pallet'];
				
		try {
			$pallet1 = new pallet;

			$pallet1->pallet = $pallet;
									
			$pallet1->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			return view('pallet.error');			
		}
		
		return Redirect::to('/pallet');

	}

	public function edit($id) {

		$pallet = pallet::findOrFail($id);		
		return view('pallet.edit', compact('pallet'));
	}

	public function update($id, Request $request) {
		//
		$this->validate($request, ['pallet'=>'required']);

		$pallet1 = pallet::findOrFail($id);		
		$input = $request->all(); 
		
		try {
			$pallet1->pallet = $input['pallet'];
			$pallet1->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			return view('pallet.error');			
		}
		
		return Redirect::to('/pallet');
	}


	public function delete($id) {

		$pallet = pallet::findOrFail($id);
		$pallet->delete();

		return Redirect::to('/pallet');
	}



}
