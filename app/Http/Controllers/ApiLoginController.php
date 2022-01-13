<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;
use Illuminate\Support\Facades\Hash;

class ApiLoginController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "user";        
				$this->permalink   = "login";    
				$this->method_type = "get";    
		    }
		

		    public function hook_before(&$postdata) {
				//This method will be execute before run the main process
				$nik = g('nik');
				$pass = g('password');

				$resp=[];
				if($nik && $pass) {
					$user = DB::table('user')
					->where('nik',$nik)
					->first();
					if (Hash::check($pass, $user->password)) {
						if($user->stat_approve == 'Approved'){
							
							$resp['api_status']=1;
							$resp['api_message']='Success';
							$resp['nik']=$nik;
							$resp['nama']=$user->nama;
							$resp['foto']=strval(CRUDBooster::getSetting('home_path').$user->foto);
							$token = Hash::make($nik.date('Y-m-d H:i:s'));

							$resp['token']=$token;
							DB::table('user')->where('nik',$nik)->update(['token'=>$token]);
							
						}		
						else if($user->stat_approve == 'Rejected')	{
							$resp['api_status'] = 0;
							$resp['api_message'] = 'User Rejected, hubungi admin';	
						}
						else{
							$resp['api_status'] = 0;
							$resp['api_message'] = 'User masih dalam evaluasi admin';	
						}			
					}else{
						$resp['api_status'] = 0;
					$resp['api_message'] = 'Username atau password yang anda masukkan salah';
					
					}
		    	}else{
					$resp['api_status'] = 0;
					$resp['api_message'] = 'Mohon mengisi username dan password';
					
				}
					response()->json($resp)->send();
	    			exit;
		    }

		    public function hook_query(&$query) {
		        //This method is to customize the sql query

		    }

		    public function hook_after($postdata,&$result) {
		        //This method will be execute after run the main process

		    }

		}