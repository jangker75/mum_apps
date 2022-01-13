<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;
		use Carbon\Carbon;
		class ApiRegisController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "users";        
				$this->permalink   = "regis";    
				$this->method_type = "get";    
		    }


		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$nik = g('nik');
				$alamat = g('alamat');
				$nama = g('nama');
				if($nik && $alamat && $nama) {
					if (strlen($nik) ==16) {
						$kode_prov = substr($nik, 0,2);
						$kode_kota = substr($nik, 2,2);
						$kode_kec = substr($nik, 4,2);
						$tgl_lahir = substr($nik, 6,2);
						$gender = substr($nik, 6,1);
						$bln_lahir = substr($nik, 8,2);
						$tahun_lahir = substr($nik, 10,2);
						$data_prov = DB::table('provinsi')->where('kode',$kode_prov)->first();
						$data_kota = DB::table('kota')->where('provinsi_id',$data_prov->id)->where('kode',$kode_kota)->first();
						$data_kec = DB::table('kecamatan')->where('provinsi_id',$data_prov->id)->where('kota_id',$data_kota->id)->where('kode',$kode_kec)->first();

						if($data_prov && $data_kota && $data_kec)
						{
							if ($gender<4){
								$jk = 'Laki-Laki';

							}else {
								$tgl_lahir = $tgl_lahir-40;
								if (strlen($tgl_lahir)<2) {
									$tgl_lahir = '0'.$tgl_lahir;
								}
								$jk = 'Perempuan';
							}
							if ($tahun_lahir >=30) {
								$thn = '19'.$tahun_lahir;
							}else {
								$thn = '20'.$tahun_lahir;
							}
							// tanggal lahir
							
							$tanggal_lahir =$tgl_lahir.'-'.$bln_lahir.'-'.$thn;
							$usia =	Carbon::parse($tanggal_lahir)->diff(Carbon::now())->format('%y Tahun, %m Bulan and %d Hari');
							  
						
							$save = [];

							$save['NIK'] = $nik;
							$save['Nama'] = $nama;
							$save['Alamat'] = $alamat;
							$save['Provinsi'] = $data_prov->nama;
							$save['Kota'] = $data_kota->nama;
							$save['Kecamatan'] = $data_kec->nama;
							$save['Kode Pos'] = $data_kec->kode_pos;
							$save['Jenis Kelamin'] = $jk;
							$save['Tanggal Lahir'] = $tanggal_lahir;
							$save['Usia'] = $usia;
							


							$rec['nik'] = $nik;
							$rec['nama'] = $nama;
							$rec['alamat'] = $alamat;
							$rec['provinsi_id'] = $data_prov->id;
							$rec['kota_id'] = $data_kota->id;
							$rec['kecamatan_id'] = $data_kec->id;
							$rec['gender'] = $jk;
							
							DB::table('users')->insert($rec);
							$resp = response()->json(['api_status'=>1,'api_message'=>'Success', 'data'=>$save]);
							$resp->send();
							exit;						
						}
						else{
							$resp = response()->json(['api_status'=>0,'api_message'=>'NIK Tidak terdaftar']);
							$resp->send();
							exit;
						}
					}
					else {
						$resp = response()->json(['api_status'=>0,'api_message'=>'Panjang NIK harus 16 Karakter']);
						$resp->send();
						exit;
					}
			
				}
				else{
					$resp = response()->json(['api_status'=>0,'api_message'=>'Mohon Lengkapi data NIK, Nama dan Alamat']);
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