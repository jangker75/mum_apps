<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;

		class ApiScanTenantController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "lacak";        
				$this->permalink   = "scan_tenant";    
				$this->method_type = "post";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$nik = g('nik');
				$qr = g('qr_id');

				if(empty($nik) && empty($qr)) {
					$resp = response()->json(['api_status'=>0,'api_message'=>'Mohon isi NIK dan Scan QR']);
	    			$resp->send();
					exit;
				}
				else{
				if($tenant = DB::table('tenant')->where('qr_id',$qr)->first()) 
				{
					$user = DB::table('user')
					->where('nik',$nik)
					->first();

					$lacak = DB::table('lacak')
					->where('user_id',$user->id)
					->Where('tenant_id',$tenant->id)
					->orderBy('id', 'desc')
					->first();
					
					if ($lacak->status == "Check-Out") 
					{
						$idLacak =	DB::table('lacak')->insertGetId([
							'tenant_id'=>$tenant->id,
							'status'=>"Check-In",
							'user_id'=>$user->id]);

						$lastRow = 	$lacak = DB::table('lacak')
						->where('id',$idLacak)->first();
						DB::table('user')->where('nik',$nik)
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

							$lastRow = DB::table('lacak')
							->where('id',$idLacak)->first();
							
							DB::table('user')->where('nik',$nik)
							->update(['last_checkout_date'=>$lastRow->timescan,
								'last_checkout_tenant'=>$tenant->id,
								'status_check'=>"Check-Out"]);
							$resp = response()->json(['api_status'=>1,'api_message'=>'Success']);
							$resp->send();
							exit;
					}else {
							$idLacak = DB::table('lacak')->insertGetId([
							'tenant_id'=>$tenant->id,
							'status'=>"Check-In",
							'user_id'=>$user->id]);

							$lastRow = DB::table('lacak')
							->where('id',$idLacak)->first();
							DB::table('user')->where('nik',$nik)
							->update(['last_checkin_date'=>$lastRow->timescan,
								'last_checkin_tenant'=>$tenant->id,
								'status_check'=>"Check-In"]);
							$resp = response()->json(['api_status'=>1,'api_message'=>'Success']);
					$resp->send();
					exit;
					}
				}
				else{
					$resp = response()->json(['api_status'=>0,'api_message'=>'Tenant Tidak Terdaftar']);
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