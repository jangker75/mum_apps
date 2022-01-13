<?php namespace App\Http\Controllers;

use crocodicstudio\crudbooster\helpers\CRUDBooster as HelpersCRUDBooster;
use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use Carbon;

	class AdminDashboardController extends Controller {

		public function getIndex() {
			if(CRUDBooster::isSuperadmin() || CRUDBooster::myPrivilegeId()=='3'){

				$data['countClient'] = DB::table('client')->count();
				$data['countUser'] = DB::table('user')->where('stat_approve','=','Approved')->count();
				$data['countNewUser'] = DB::table('user')->where('stat_approve','=','Pending')->count();
				$data['countLokasiTenant'] = DB::table('tenant')->count();
				
				$data['visitTerbaru'] =DB::table('lacak')
						->join('user','user.id','=','lacak.user_id')
						->join('tenant','tenant.id','=','lacak.tenant_id')
						->join('client','client.id','=','tenant.client_id')
						->select('lacak.*','client.nama as nama_client',
						'user.nama as nama_user','tenant.nama as nama_tenant',
						'tenant.alamat as area_tenant')
						->orderBy('lacak.id','desc')->limit('10')->get();
			}
					else{
						$client = DB::table('cms_users')->where('id',CRUDBooster::myId())->first();
						$data['countClient'] = DB::table('client')->where('id',$client->client_id)->count();
						$data['countUser'] = DB::table('user')->where('client_id',$client->client_id)->where('stat_approve','Approved')->count();
						$data['countNewUser'] = DB::table('user')->where('stat_approve','=','Pending')->count();
						$data['countLokasiTenant'] = DB::table('tenant')->count();
						
						$data['visitTerbaru'] =DB::table('lacak')
								->join('user','user.id','=','lacak.user_id')
								->join('tenant','tenant.id','=','lacak.tenant_id')
								->join('client','client.id','=','tenant.client_id')
								->select('lacak.*','client.nama as nama_client',
								'user.nama as nama_user','tenant.nama as nama_tenant',
								'tenant.alamat as area_tenant')
								->where('client.id',$client->client_id)
								->orderBy('lacak.id','desc')->limit('10')->get();
			}
			return view('admin_dashboard', $data);
		}
		public function getTenantMarker()
		{
			$hasil =[];
			$rows = DB::table('tenant')
			->join('client','client.id','=','tenant.client_id')
			->select('tenant.*','client.nama as nama_client')
			->get();
			foreach ($rows as &$item) {
				$item->marker = 'http://maps.google.com/mapfiles/kml/shapes/ranger_station.png';
				$hasil[] = $item;
			}

			return response()->json($hasil);
		}
		public function getLoadMarker() {
			$jenis = g('jenis');
			$rows = DB::table('lacak')
			->join("user","user.id","=","lacak.user_id")
			->join("tenant","tenant.id","=","lacak.tenant_id")
			->join("client","client.id","=","tenant.client_id")
			->select('lacak.*', 'user.nama as nama_user','user.nik as no_ktp','tenant.nama as nama_tenant'
			,'tenant.alamat as area_tenant','client.nama as nama_client' );
			$rows->where('timescan', '>=', date('Y-m-d').' 00:00:00');
			$result=$rows->get();

			$hasil = [];
			foreach($result as &$r) {
				$r->foto_visit = asset($r->foto1);
				if($r->status_radius_visit == "In Range") {
					$r->marker = 'http://maps.google.com/mapfiles/ms/icons/green.png';
				}else{
					$r->marker = 'http://maps.google.com/mapfiles/ms/icons/red.png';
				}

				if($jenis) {
					if($jenis=='Green') {
						if($r->status_radius_visit == "In Range") {
							$hasil[] = $r;
						}
					}elseif ($jenis == 'Red') {
						if($r->status_radius_visit == "Out of Range") {
							$hasil[] = $r;
						}
						
					}else{
						$hasil[] = $r;
					}
				}else{
					$hasil[] = $r;
				}
			}
			// dd($hasil);
			return response()->json($hasil);
		}


	}