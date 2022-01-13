<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;

		class ApiScanQrController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "tenant";        
				$this->permalink   = "scan_qr";    
				$this->method_type = "get";    
		    }
		
		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$qr = g('qr_id');
				$response=[];
				if($tenant = DB::table('tenant')->where('qr_id',$qr)->first()) 
				{
					$response['api_status'] 	= 1;
					$response['api_message']	= 'Success';
					$response['data'] = $tenant;
					
				}else{

					$response['api_status'] 	= 0;
					$response['api_message']	= 'Tenant Tidak Terdaftar';
					
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