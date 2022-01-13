<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;
use Illuminate\Support\Facades\Hash;

class ApiReqqrController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "user";        
				$this->permalink   = "reqqr";    
				$this->method_type = "get";    
		    }


		    public function hook_before(&$postdata) {
				$nik = g('nik');
				
				$a = DB::table('user')
					->where('nik',$nik)
					->first();
				if ($a) {
					$hashed = Hash::make($a->nik.strval(rand(1000,1000000)));
					DB::table('user')->where('nik',$nik)->update(['nikhash'=>$hashed]);
					$resp = response()->json(['api_status'=>1,'api_message'=>'Success generated NIK', 'hashnik'=>$hashed]);
					$resp->send();
					exit;
				}else{
					$resp = response()->json(['api_status'=>0,'api_message'=>'NIK tidak terdaftar']);
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