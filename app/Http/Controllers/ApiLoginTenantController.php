<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;
		use Illuminate\Support\Facades\Hash;
		class ApiLoginTenantController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "user_tenant";        
				$this->permalink   = "login_tenant";    
				$this->method_type = "get";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$username = g('username');
				$pass = g('password');
				if ($username && $pass) {
					$user_tenant = DB::table('user_tenant')->where('username',$username)->first();
					$tenant = DB::table('tenant')->where('id',$user_tenant->id_tenant)->first();
					if (Hash::check($pass, $user_tenant->password) && $tenant) {
						$resp=[];
						$resp['api_status']=1;
						$resp['api_message']='Success';
						$resp['username']=$user_tenant->username;
						$resp['nama_user']=$user_tenant->nama;
						$resp['nama_tenant']=$tenant->nama;
						$resp['alamat_tenant']=$tenant->alamat;
						$resp['kota_tenant']=$tenant->kota;
						$resp['qr_id']=$tenant->qr_id;
						$token = Hash::make($tenant->qr_id.date('Y-m-d H:i:s'));
						$resp['token']=$token;
						DB::table('user_tenant')->where('id',$user_tenant->id)->update(['token'=>$token]);
						response()->json($resp)->send();
						exit;	
					} else {
						$resp = response()->json(['api_status'=>0,'api_message'=>'Username atau password yang anda masukkan salah']);
						$resp->send();
						exit;
					}
					
				}else {
					$resp = response()->json(['api_status'=>0,'api_message'=>'Mohon mengisi username dan password']);
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