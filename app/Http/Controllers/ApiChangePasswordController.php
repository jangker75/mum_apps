<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;
		use Hash;
		class ApiChangePasswordController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "user";        
				$this->permalink   = "change_password";    
				$this->method_type = "post";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$id=g('nik');
		        $old_pass=g('old_pass');
		        $new_pass=g('new_pass');
		        //

		        //Mengambil data users yang sesuai dengan parameter id
		    	$query=DB::table('user')
		    	->where('nik',$id)
		    	->first();
		    	//
		    	if (empty($query)) {
		    		//Kondisi jika id users tidak terdaftar
		    		$response['api_status']=0;
		    		$response['api_message']='User belum terdaftar';
		    		response()->json($response)->send();
		    		exit();
		    		//
		    	}else{

			    	if (!Hash::check($old_pass, $query->password )) {
			    		//Kondisi jika password dari parameter tidak sama dengan password dari data users
			    		$response['api_status']=0;
		    			$response['api_message']='Password lama anda salah';
		    			response()->json($response)->send();
		    			exit();
		    			//
			    	}else{
			    		//Menambahkan array data untuk mengubah password berdasarkan id users dari parameter
			    		// $data=array(
				    	// 	'password'=>Hash::make($new_pass)
				    	// );
				    	// $kw=DB::table('user')->where('nik',$id)
				    	// ->update($data);
				    	$kw=DB::table('user')->where('nik',$id)
				    	->update(['password'=>Hash::make($new_pass)]);
				    	//
				    	if ($kw) {
				    		//kondisi jika id users di parameter ada di data users
				    		$response['api_status']=1;
			    			$response['api_message']='Berhasil mengubah password';
							$response['nama_user']=$query->nama;
							$response['nik']=$query->nik;
			    			response()->json($response)->send();
			    			exit();
			    			//
				    	}else{
				    		//kondisi jika id users di parameter tidak ada di data users
				    		$response['api_status']=0;
			    			$response['api_message']='Gagal mengubah password';
			    			response()->json($response)->send();
			    			exit();
			    			//
				    	}

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