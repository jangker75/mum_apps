<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;
		use Carbon\Carbon;

		class ApiScanVisitController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "lacak";        
				$this->permalink   = "scan_visit";    
				$this->method_type = "post";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
			//deklarasi variabel yang dibutuhkan
			$nik 	= g('nik');
			$qr  = g('qr_id');
			$notes	= g('notes');
			$longitude	= g('longitude');
			$latitude	= g('latitude');

			$userID = DB::table('user')->where('nik',$nik)->first();
			$tenantID = DB::table('tenant')->where('qr_id',$qr)->first();		
			
			$date = date('Y-m-d');
			$path = "uploads/1/" . $date;
			$foto = Request::file('foto');

			$current = Carbon::now();
			// $curdate = $current->format("d-m-Y");
			// $curtime = $current->format("h-i-s");
			if($foto!=null){
				$extension = $foto->getClientOriginalExtension();
				$poto = rand(11111, 99999) . "." . $extension;
				$foto->move($path, $poto);
				$save['foto1'] = $path . '/' . $poto;
				}
		
			$jarak = cekAreaRange($tenantID->latitude, $tenantID->longitude,$latitude, $longitude,'meters');
			$status_visit = 'In Range';
			// if($jarak>50.0){
			if($jarak>CRUDBooster::getSetting('radius_checkin')){
				$status_visit = 'Out of Range';
			}
			$save['status_radius_visit']  = $status_visit;
			$save['tanggal_scan'] = $current->format("Y-m-d");
			$save['waktu_scan'] = $current->format("H:i:s");
			$save['user_id'] = $userID->id;
			$save['tenant_id'] = $tenantID->id;
			$save['notes'] = $notes;
			$save['latitude'] = $latitude;
			$save['longitude'] = $longitude;
			$save['jarak_titik'] = $jarak;
			// $save['latitude_tenant'] = $tenantID->latitude;
			// $save['longitude_tenant'] = $tenantID->longitude;

			// dd($save);
			DB::table('lacak')->insert($save);
			$response['api_status'] 	= 1;
			$response['api_message']	= 'Berhasil menyimpan';
			
			response()->json($response)->send();
			exit();

		    }

		    public function hook_query(&$query) {
		        //This method is to customize the sql query

		    }

		    public function hook_after($postdata,&$result) {
		        //This method will be execute after run the main process

		    }

		}