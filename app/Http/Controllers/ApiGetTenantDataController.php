<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;
		use Illuminate\Support\Facades\Hash;
		class ApiGetTenantDataController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "tenant";        
				$this->permalink   = "get_tenant_data";    
				$this->method_type = "get";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$token = g('token');
				
				$a = DB::table('user_tenant')
					->where('token',$token)
					->first();
				if ($a) {
					$tenant = DB::table('tenant')->where('id',$a->id_tenant)->first();
				$resp = [];
						$resp['api_status'] = 1;
						$resp['api_message'] = "Success";
						$resp['username']=$a->username;
						$resp['nama_user']=$a->nama;
						$resp['nama_tenant']=$tenant->nama;
						$resp['alamat_tenant']=$tenant->alamat;
						$resp['kota_tenant']=$tenant->kota;
						$resp['qr_id']=$tenant->qr_id;
					
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