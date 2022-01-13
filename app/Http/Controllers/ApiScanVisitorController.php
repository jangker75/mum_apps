<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;

		class ApiScanVisitorController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "lacak";        
				$this->permalink   = "scan_visitor";    
				$this->method_type = "post";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$username = g('username');
				$qr = g('qr_id');

				if(empty($username) && empty($qr)) {
					$resp = response()->json(['api_status'=>0,'api_message'=>'Mohon isi Username dan Scan QR']);
	    			$resp->send();
					exit;
				}
				else{
					$user = DB::table('user')->where('nikhash',$qr)->first();
					$user_tenant = DB::table('user_tenant')->where('username',$username)->first();
					$tenant = DB::table('tenant')->where('id',$user_tenant->id_tenant)->first();
					if($user_tenant && $tenant && $user) 
					{
						$lacak = DB::table('lacak')
						->where('user_id',$user->id)
						->Where('tenant_id',$tenant->id)
						->orderBy('id', 'desc')
						->first();
						
						if ($lacak->status == "Check-Out") 
						{
							$idLacak = DB::table('lacak')->insertGetId([
								'tenant_id'=>$tenant->id,
								'status'=>"Check-In",
								'user_id'=>$user->id]);
								
								$lastRow= DB::table('lacak')
								->where('id',$idLacak)->first();

								DB::table('user')->where('nik',$user->nik)
								->update(['last_checkin_date'=>$lastRow->timescan,
									'last_checkin_tenant'=>$tenant->id,
									'status_check'=>"Check-In"]);
								
								$resp = response()->json(['api_status'=>1,'api_message'=>'Success']);
								$resp->send();
								exit;
						}else if($lacak->status == "Check-In")
						{
							$idLacak = DB::table('lacak')->insertGetId([
								'tenant_id'=>$tenant->id,
								'status'=>"Check-Out",
								'user_id'=>$user->id]);

								$lastRow= DB::table('lacak')
								->where('id',$idLacak)->first();
								
								DB::table('user')->where('nik',$user->nik)
								->update(['last_checkout_date'=>$lastRow->timescan,
									'last_checkout_tenant'=>$tenant->id,
									'status_check'=>"Check-Out"]);
								$resp = response()->json(['api_status'=>1,'api_message'=>'Success']);
								$resp->send();
								exit;
						}else {
							$idLacak= DB::table('lacak')->insertGetId([
								'tenant_id'=>$tenant->id,
								'status'=>"Check-In",
								'user_id'=>$user->id]);

								$lastRow = DB::table('lacak')
							->where('id',$idLacak)->first();

							DB::table('user')->where('nik',$user->nik)
							->update(['last_checkin_date'=>$lastRow->timescan,
								'last_checkin_tenant'=>$tenant->id,
								'status_check'=>"Check-In"]);
								$resp = response()->json(['api_status'=>1,'api_message'=>'Success']);
						$resp->send();
						exit;
						}
					}
					else{
						$resp = response()->json(['api_status'=>0,'api_message'=>'Visitor Tidak Terdaftar']);
						$resp->send();
						exit;							
					}
		    	}
		    }

		    public function hook_query(&$query) {
		        //This method is to customize the sql query

		    }

		    public function hook_after($postdata,&$result) {
		        //This method will be execute after run the main process

		    }

		}