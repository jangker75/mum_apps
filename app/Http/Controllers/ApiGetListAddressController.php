<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;

		class ApiGetListAddressController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "provinsi";        
				$this->permalink   = "get_list_address";    
				$this->method_type = "get";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$prov = g('provinsi');
				$kota = g('kota');
				$kec = g('kecamatan');
				$data = [];
				$provData = DB::table('provinsi')->where('nama', $prov)->first();
				$kotaData = DB::table('kota')->where('nama', $kota)->first();
				$provList = DB::table('provinsi')->get(['id', 'nama']);
				if($provData){
					$kotaList = DB::table('kota')->where('provinsi_id', $provData->id)->get(['id', 'nama']);
					if ($kotaData) {
						$kecList = DB::table('kecamatan')->where('kota_id', $kotaData->id)->where('provinsi_id', $provData->id)->get(['id', 'nama']);
						$data['provinsi'] = $provList;
						$data['kota'] = $kotaList;
						$data['kecamatan'] = $kecList;
					} else {
						$data['provinsi'] = $provList;
						$data['kota'] = $kotaList;
						$data['kecamatan'] = [];
					}
				}
				else{
					$data['provinsi'] = $provList;
					$data['kota'] = [];
					$data['kecamatan'] = [];
				}
				$response['api_status'] 	= 1;
				$response['api_message']	= 'success';
				$response['data'] = $data;
				response()->json($response)->send();
				exit;
		    }

		    public function hook_query(&$query) {
		        //This method is to customize the sql query

		    }

		    public function hook_after($postdata,&$result) {
		        //This method will be execute after run the main process

		    }

		}