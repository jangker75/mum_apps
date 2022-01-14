<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;
		use Illuminate\Support\Facades\Hash;
		class ApiGetUserDataController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "user";        
				$this->permalink   = "get_user_data";    
				$this->method_type = "get";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$token = g('token');
				
				$a = DB::table('user')
					->where('token',$token)
					->first();
				if ($a) {
					$nikhash = Hash::make($a->nik.date('Y-m-d H:i:s'));
					$resp = [];
						$resp['api_status'] = 1;
						$resp['api_message'] = "Success";
						$resp['nik'] = $a->nik;
						$resp['nama'] = $a->nama;
						$resp['nikhash'] = $nikhash;
						$resp['foto']=strval(url('/').'/'.$a->foto);
						// $resp['foto']=strval(CRUDBooster::getSetting('home_path').$a->foto);
					DB::table('user')->where('nik',$a->nik)->update(['nikhash'=>$nikhash]);
					response()->json($resp)->send();
					exit;
				}else{
					$resp = response()->json(['api_status'=>0,'api_message'=>'Token tidak ada']);
					$resp->send();
					exit;
				}
		    }

		    public function hook_query(&$query) {
		        //This method is to customize the sql query

		    }

		    public function hook_after($postdata,&$result) {
		        //This method will be execute after run the main process

		    }

		}