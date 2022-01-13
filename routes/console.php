<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('fix_pendataan',function() {
	$data = DB::table('kuisoner')->get();
	foreach($data as $d) {
		$ids = DB::table('kuisoner')->where('id_member',$d->id_member)->where('id_event',$d->id_event)->where('id','!=',$d->id)->pluck('kuisoner.id')->toArray();
		DB::table('kuisoner')->whereIn('id',$ids)->delete();
	}

	$data = DB::table('kuisoner_detail')->get();
	foreach($data as $d) {
		$ids = DB::table('kuisoner_detail')->where('id_soal',$d->id_soal)->where('id_kuisoner',$d->id_kuisoner)->where('id','!=',$d->id)->pluck('kuisoner_detail.id')->toArray();
		DB::table('kuisoner_detail')->whereIn('id',$ids)->delete();
	}
});

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('fix_tps',function() {
	ini_set('memory_limit', '256M');
	
	// DB::table('tps')->delete();
	$kelurahan = DB::table('desa')
	->join('kecamatan','kecamatan.id','=','id_kecamatan')	
	->select('desa.*','kecamatan.id_kabupaten')	
	->get();
	foreach($kelurahan as $k) {
		DB::table('tps')->insert([
			'id_kabupaten'=>$k->id_kabupaten,
			'id_kecamatan'=>$k->id_kecamatan,
			'id_desa'=>$k->id,			
			'nama'=>'TPS '.$k->nama
		]);
		$this->comment('TPS '.$k->nama);
	}
});

Artisan::command('dummy',function() {
	$fake = \Faker\Factory::create('id_ID');
	$password = \Hash::make(123456);

	$kota = ['Jakarta','Semarang','Surabaya','Salatiga','Yogyakarta','Bandung','Jepara','Medan','Lampung','Gorontalo','Batam','Pontianak'];
	$agama = ['Islam','Hindu','Budha','Kristen','Katolik','Lain-lain'];
	$pendidikan = ['Ekonomi','Manajemen','Akuntansi','Astronomi','Perbankan','SMA','SMP','SD','Komputer','Sastra Inggris','PGSD','Pendidikan Matematika','Pendidikan Bahasa Inggris'];
	$pekerjaan = ['PNS','Swasta','Wiraswasta'];
	$jenis_barang = ['Mie Instant','Sembako','Elektronik','Uang','Pakaian','Makanan'];

	$pertanyaan = ['Apakah anda bersedia menjadi kader Nasdem ?','Apakah anda tau dan mengenal Rahmat Gobel (RG) ?'];

	$prefixEvent = "Survey Nasdem";

	$id_provinsi = 75;
	$id_kabupaten_utama = 7571;
	$id_kecamatan_utama = 757106;
	$targetPerEvent = 1000;

	//create surveyor
	// DB::table('surveyor')->delete();
	// for($i=1;$i<=20;$i++) {
	// 	$a = [];
	// 	$a['nama'] = $fake->name;
	// 	$a['no_hp'] = $fake->phone;
	// 	$a['email'] = $fake->email;
	// 	$a['password'] = $password;
	// 	DB::table('surveyor')->insert($a);
	// 	$this->comment('Surveyor: '.$a['nama']);
	// }

	//member
	DB::table('member')->delete();
	$id_surveyor = DB::table('surveyor')->pluck('id')->toArray();
	$id_kabupaten = DB::table('kabupaten')->where('id_provinsi',$id_provinsi)->pluck('id')->toArray();

	for($i=1;$i<=200;$i++) {

		$a = [];
		$a['created_at'] = date('Y-m-d H:i:s');
		$a['nama'] = $fake->name;
		$a['no_ktp'] = genNoKTP();
		$a['no_kta'] = $a['no_ktp'].'1';
		$a['no_kk'] = $a['no_ktp'];
		$a['jenis_kelamin'] = $fake->randomElement(['LAKI-LAKI','PEREMPUAN']);
		$a['tempat_lahir'] = $fake->randomElement($kota);
		$a['tanggal_lahir'] = $fake->date('Y-m-d', '1999-01-01');
		$a['agama'] = $fake->randomElement($agama);
		$a['pendidikan_terakhir'] = $fake->randomElement($pendidikan);
		$a['pekerjaan'] = $fake->randomElement($pekerjaan);
		$a['alamat'] = $fake->streetAddress;
		$a['id_provinsi'] = $id_provinsi; //gorontalo
		$a['id_kabupaten'] = $id_kabupaten_utama;
		$a['id_kecamatan'] = $id_kecamatan_utama;
		$a['id_kelurahan'] = DB::table('kelurahan')->where('id_kecamatan',$a['id_kecamatan'])->take(1)->orderByRaw('RAND()')->first()->id_kel;
		$a['nomor_hp'] = $fake->e164PhoneNumber;
		$a['email'] = $fake->email;
		$a['point'] = 0;
		$a['latitude'] = $fake->latitude(0.9,0.3);
		$a['longitude'] = $fake->longitude(123,121);
		$a['id_surveyor'] = $fake->randomElement($id_surveyor);
		DB::table('member')->insert($a);
		$this->comment('Member: '.$a['nama']);
	}


	//Create Event 	
	DB::table('event')->delete();
	DB::table('soal')->delete();
	DB::table('soal_jawaban')->delete();
	for($i=1;$i<=2;$i++) {
		$a = [];
		$a['nama'] = $prefixEvent.' Periode '.$i;
		$a['tanggal_mulai'] = date('Y').'-'.str_pad($i, 2,0, STR_PAD_LEFT).'-01';
		$a['tanggal_selesai'] = date('Y').'-'.str_pad($i, 2,0,STR_PAD_LEFT).'-31';
		$a['target'] = $targetPerEvent;
		$a['id_provinsi'] = $id_provinsi;
		$a['id_kabupaten'] = $id_kabupaten_utama;
		$a['id_kecamatan'] = $id_kecamatan_utama;
		$a['alamat'] = DB::table('kabupaten')->where('id',$id_kabupaten_utama)->first()->nama;
		$a['latitude'] = $fake->latitude(0.9,0.3);	
		$a['longitude'] = $fake->longitude(123,121);	
		$a['is_active'] = ($i==date('n'))?1:0;
		$id_event = DB::table('event')->insertGetId($a);
		$this->comment('Event: '.$a['nama']);

		foreach($pertanyaan as $ip=>$per) {
			$b = [];
			$b['isi'] = $per;
			$b['tipe'] = 'Radio';
			$b['urutan'] = ($ip+1);
			$b['jenis'] = 'Survey';
			$b['id_event'] = $id_event;
			$id_soal = DB::table('soal')->insertGetId($b);

			$c = [];
			$c['id_soal'] = $id_soal;
			$c['jawaban'] = 'Ya';
			$c['input_keterangan'] = 0;
			DB::table('soal_jawaban')->insert($c);

			$c = [];
			$c['id_soal'] = $id_soal;
			$c['jawaban'] = 'Tidak';
			$c['input_keterangan'] = 0;
			DB::table('soal_jawaban')->insert($c);
		}	
		
	}

	//kuisoner
	DB::table('kuisoner')->delete();
	DB::table('kuisoner_detail')->delete();
	$member = DB::table('member')->get();
	$events = DB::table('event')->get();
	foreach($member as $m) {

		foreach($events as $e) {

			$sebanyak = rand(1,10);
			for($i=1;$i<=$sebanyak;$i++) {
				$a = [];
				// $a['created_at'] = $fake->dateTimeBetween($e->tanggal_mulai, $e->tanggal_selesai);
				$a['no_kuisoner'] = str_pad( DB::table('kuisoner')->count()+1, 6, 0, STR_PAD_LEFT);
				$a['id_surveyor'] = $fake->randomElement($id_surveyor);
				$a['id_event'] = $e->id;
				$a['id_member'] = $m->id;
				$a['foto1'] = 'uploads/2018-01/446ab30116319e2de571187e28787424.';
				$a['foto2'] = 'uploads/2018-01/446ab30116319e2de571187e28787424.';
				$a['foto3'] = 'uploads/2018-01/446ab30116319e2de571187e28787424.';
				$a['catatan'] = $fake->sentence(6);
				$a['latitude'] = $m->latitude;
				$a['longitude'] = $m->longitude;
				$idKuisoner = DB::table('kuisoner')->insertGetId($a);
				$this->comment('Kuisoner: '.$a['no_kuisoner']);
				
				$soals = DB::table('soal')->where('id_event',$e->id)->get();
				foreach($soals as $so) {
					$jawaban = DB::table('soal_jawaban')->where('id_soal',$so->id)->pluck('id')->toArray();
					$ss = [];
					$ss['id_kuisoner'] = $idKuisoner;
					$ss['id_soal'] = $so->id;
					$ss['id_soal_jawaban'] = $fake->randomElement($jawaban);
					DB::table('kuisoner_detail')->insert($ss);
				}

			}


			for($i=1;$i<=$sebanyak;$i++) {
				$a = [];
				// $a['created_at'] = $fake->dateTimeBetween($e->tanggal_mulai, $e->tanggal_selesai);				
				$a['id_surveyor'] = $fake->randomElement($id_surveyor);
				$a['id_event'] = $e->id;
				$a['id_member'] = $m->id;
				$a['jenis_barang'] = $fake->randomElement($jenis_barang);
				$a['foto1'] = 'uploads/2018-01/446ab30116319e2de571187e28787424.';
				$a['foto2'] = 'uploads/2018-01/446ab30116319e2de571187e28787424.';
				$a['foto3'] = 'uploads/2018-01/446ab30116319e2de571187e28787424.';
				$a['catatan'] = $fake->sentence(6);
				$a['latitude'] = $m->latitude;
				$a['longitude'] = $m->longitude;
				$id_distribusi = DB::table('distribusi')->insertGetId($a);
				$this->comment('Distribusi: '.$id_distribusi);				

			}
		}
		
	}


});
