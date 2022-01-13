<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use Carbon\Carbon;
		use CRUDBooster;
use Illuminate\Support\Facades\Hash;

class ApiDaftaruserController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "user";        
				$this->permalink   = "daftaruser";    
				$this->method_type = "post";    
		    }
		

		    public function hook_before(&$postdata) {
				//This method will be execute before run the main process
				$nik = g('nik');
				$password = g('password');
				$nama = g('nama');
				$alamat = g('alamat');
				if($nik && $password) {
					if($user = DB::table('user')->where('nik',$nik)->first())
					{
						$resp = response()->json(['api_status'=>0,'api_message'=>'NIK Sudah terdaftar']);
						$resp->send();
						exit;
					}else{
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
								$save['Provinsi'] = $data_prov->nama;
								$save['Kota'] = $data_kota->nama;
								$save['Kecamatan'] = $data_kec->nama;
								$save['Kode Pos'] = $data_kec->kode_pos;
								$save['Jenis Kelamin'] = $jk;
								$save['Tanggal Lahir'] = $tanggal_lahir;
								$save['Usia'] = $usia;
								
	
	
								$rec['nik'] = $nik;
								$rec['nama'] = $nama;
								$rec['password'] = Hash::make($password);
								$rec['provinsi_id'] = $data_prov->id;
								$rec['kota_id'] = $data_kota->id;
								$rec['kecamatan_id'] = $data_kec->id;
								$rec['gender'] = $jk;
								$rec['alamat'] = $alamat;

								DB::table('user')->insert($rec);
								$resp = response()->json(['api_status'=>1,'api_message'=>'Selamat pendaftaran berhasil', 'data'=>$save]);
								$resp->send();
								exit;						
							}
							else{
								$resp = response()->json(['api_status'=>0,'api_message'=>'Format NIK Tidak terdaftar']);
								$resp->send();
								exit;
							}
						}
						else {
							$resp = response()->json(['api_status'=>0,'api_message'=>'Panjang NIK harus 16 Karakter']);
							$resp->send();
							exit;
						}

						// $save = [];
						// $save['nik'] = $nik;
						// $save['password'] = Hash::make($password);
						// $save['nama'] = $nama;
						// DB::table('user')->insert($save);
						// $resp = response()->json(['api_status'=>1,'api_message'=>'Selamat pendaftaran berhasil']);
						// $resp->send();
						// exit;						

					}
			
				}
				else{
					$resp = response()->json(['api_status'=>0,'api_message'=>'Mohon mengisi data']);
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