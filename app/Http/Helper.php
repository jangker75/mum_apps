<?php 
function sortingIcon($name) {
	if(g('sort_name')==$name) {
		if(g('sort_value')=='asc') {
			return "<i class='fa fa-sort-desc'></i>";
		}elseif (g('sort_value')=='desc') {
			return "<i class='fa fa-sort-asc'></i>";
		}else{
			return "<i class='fa fa-sort'></i>";
		}
	}else{
		return "<i class='fa fa-sort'></i>";
	}
}
function linkSorting($name) {
	$url = addToUrl(Request::fullUrl(),'sort_name',$name);
	if(g('sort_value')=='asc') {
		$url = addToUrl($url,'sort_value','desc');
	}else{
		$url = addToUrl($url,'sort_value','asc');
	}
	return $url;
}
function addToUrl($url, $key, $value = null) {
    $query = parse_url($url, PHP_URL_QUERY);
    if ($query) {
        parse_str($query, $queryParams);
        $queryParams[$key] = $value;
        $url = str_replace("?$query", '?' . http_build_query($queryParams), $url);
    } else {
        $url .= '?' . urlencode($key) . '=' . urlencode($value);
    }
    return $url;
}
function getData($table,$condition=null,$limit=null,$orderby=null) {
	$res = DB::table($table);
	if($condition) {
		$res->whereRaw($condition);
	}
	if($orderby) {
		$res->orderByRaw($orderby);
	}
	if($limit) {
		$res->take($limit);
	}
	return $res->get();
}

function redirectTo($path,$message,$type) {
	CRUDBooster::redirect($path,$message,$type);
}

function deleteData($table,$condition) {
	$row = CRUDBooster::first($table,$condition);
	DB::table($table)->where('id',$row->id)->delete();
}

function redirectBack($message,$type) {
	CRUDBooster::redirect($_SERVER['HTTP_REFERER'],$message,$type);
}


function first($table,$condition) {
	return CRUDBooster::first($table,$condition);
}

function countData($table,$condition) {
	return DB::table($table)->whereRaw($condition)->count();
}

function getEventActive() {
	$e = DB::table('event')->whereNull('deleted_at')->where('is_active',1)->first();
	return $e;
}

function generateKTA($no_ktp) {
	return $no_ktp.'KTA';
}

function getEventIdActive() {
	$e = DB::table('event')->whereNull('deleted_at')->where('is_active',1)->first();
	return $e->id;
}

function genNoKTP() {
	$member = DB::table('member')->max('id')+1;
	$no = str_pad($member, 16, 0, STR_PAD_LEFT);
	return $no;
}

function genNoKTA() {
	// $member = DB::table('member')->max('id')+1;
	// $no = str_pad($member, 16, 0, STR_PAD_LEFT);
	// return $no.'1';
	return '';
}

function logHistory($name,$ktp,$jenis,$id_surveyor,$status=null) {
	DB::table('history')->insert([
		'nama'=>$name,
		'nik'=>$ktp,
		'jenis'=>$jenis,
		'status'=>$status,
		'id_surveyor'=>$id_surveyor
	]);
}
function cekAreaRange($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'kilometers') {
	$theta = $longitude1 - $longitude2; 
	$distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
	$distance = acos($distance); 
	$distance = rad2deg($distance); 
	$distance = $distance * 60 * 1.1515; 
	switch($unit) { 
	  case 'miles': 
		break; 
	  case 'kilometers' : 
		$distance = $distance * 1.609344; 
	  case 'meters' : 
		$distance = ($distance * 1.609344)*1000; 
	} 
	return (round($distance,3)); 
  }

  function getMapsActive() {
	$e = DB::table('lacak')->orderBy('id', 'desc')->first();
	return $e;
}