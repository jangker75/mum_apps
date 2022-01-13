<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;

		class ApiEditProfileController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "user";        
				$this->permalink   = "edit_profile";    
				$this->method_type = "post";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$nik = g("nik");
				$nip = g("nip");
				$nama = g("nama");
				$foto = Request::file('foto');
				$gender = g("gender");
				$alamat = g("alamat");
				$provinsi = g("provinsi");
				$kota = g("kota");
				$kecamatan = g("kecamatan");

				$date = date('Y-m-d');
				$path = "uploads/" . $date;
				$response = [];
				$data = DB::table('user')->where("nik", $nik)->orderBy('id','desc')->first();
				if($data){
					$dProvinsi = DB::table('provinsi')->where('nama',$provinsi)->first();
					$dKota = DB::table('kota')->where('nama',$kota)->first();
					$dKecamatan = DB::table('kecamatan')->where('nama',$kecamatan)->first();
					if($foto!=null){
						$extension = $foto->getClientOriginalExtension();
						$poto = rand(11111, 99999) . "." . $extension;
						$foto->move($path, $poto);
						$update['foto'] = $path . '/' . $poto;
						}
					$update['nama'] = $nama;
					$update['nip'] = $nip;
					$update['gender'] = $gender;
					$update['alamat'] = $alamat;
					$update['provinsi_id'] = $dProvinsi->id;
					$update['kota_id'] = $dKota->id;
					$update['kecamatan_id'] = $dKecamatan->id;
					DB::table('user')->where('nik',$nik)->update($update);
					$response['api_status'] 	= 1;
					$response['api_message']	= 'success';

				}else{
					$response['api_status'] 	= 0;
					$response['api_message']	= 'error';
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