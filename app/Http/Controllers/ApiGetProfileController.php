<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;

		class ApiGetProfileController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "user";        
				$this->permalink   = "get_profile";    
				$this->method_type = "get";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$nik = g('nik');
				$data = [];
				$user = DB::table('user')->where('nik', $nik)->orderBy('id','desc')->first();
				if($user){
					$data['nama'] = $user->nama;
					$data['nip'] = $user->nip;
					$data['nik'] = $user->nik;
					$data['gender'] = $user->gender;
					$data['alamat'] = $user->alamat;
					$data['foto'] = strval(CRUDBooster::getSetting('home_path').$user->foto);
					$data['provinsi_id'] = $user->provinsi_id;
					$data['kota_id'] = $user->kota_id;
					$data['kecamatan_id'] = $user->kecamatan_id;
					$prov = DB::table('provinsi')->where('id', $user->provinsi_id)->first();
					$kota = DB::table('kota')->where('id', $user->kota_id)->first();
					$kec = DB::table('kecamatan')->where('id', $user->kecamatan_id)->first();
					$client = DB::table('client')->where('id', $user->client_id)->first();
					$data['provinsi'] = $prov->nama;
					$data['kota'] = $kota->nama;
					$data['kecamatan'] = $kec->nama;
					$data['penempatan'] = $client->nama;

					$response['api_status'] 	= 1;
					$response['api_message']	= 'Success';
					$response['data'] = $data;
				}else{
					$response['api_status'] 	= 0;
					$response['api_message']	= 'Error NIK tidak ada';
				}
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