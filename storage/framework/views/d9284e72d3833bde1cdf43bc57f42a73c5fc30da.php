<?php $__env->startSection('content'); ?>

<?php $__env->startPush('bottom'); ?>
	<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
<?php $__env->stopPush(); ?>

<?php 
	$event = getEventActive();
?>

<h2 align="center" style="font-weight: bold;margin-bottom:20px;font-family: Arial"><?php echo e($event->nama); ?></h2>

<div class="row">
<div class="col-md-3 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Anggota</span>
      <span class="info-box-number">
      	<?php 
      		$data = DB::table('member');      		
      		echo $data->count(); 
      	?> </span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- /.col -->
<div class="col-md-3 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Relawan</span>
      <span class="info-box-number">
      	<?php 
      		$data = DB::table('surveyor');
      		// if($event->id) $data->whereRaw("surveyor.id in (select id_surveyor from event_target where id_event = '".$event->id."')");
      		echo $data->count();
      	?>      	
      </span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- /.col -->

<!-- fix for small devices only -->
<div class="clearfix visible-sm-block"></div>

<div class="col-md-3 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-green"><i class="fa fa-pencil"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Pendataan</span>
      <span class="info-box-number">
      	<?php 
      		$data = DB::table('kuisoner');
      		// if($event->id) $data->where('id_event',$event->id);
      		echo $data->count();
      	?></span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- /.col -->
<div class="col-md-3 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-yellow"><i class="fa fa-pencil"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Sosialisasi</span>
      <span class="info-box-number">
      	<?php 
      	$data = DB::table('distribusi');
      	// if($event->id) $data->where('id_event',$event->id);
      	echo $data->count();
      	?></span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- /.col -->
</div>

<?php $__env->startPush('bottom'); ?>
<script type="text/javascript">
	function showFilterWilayah() {
		$('#modal-filter-wilayah').modal('show');
	}
	function loadKabupaten() {
		var id_provinsi = $('#select-id-provinsi').val();
		var id_kabupaten = "<?php echo e(g('id_kabupaten')); ?>";
		$.get("<?php echo e(action('AdminDashboardController@getAjaxKabupaten')); ?>?id_provinsi="+id_provinsi+"&id_kabupaten="+id_kabupaten,function(r) {
			var opt = "<option value=''>Semua Kabupaten</option>";
			$.each(r,function(i,o) {
				var select = (o.selected==true)?"selected":"";
				opt += "<option "+select+" value='"+o.id+"'>"+o.nama+"</option>";
			})
			$("#select-id-kabupaten").html(opt);
			<?php if(g('id_kecamatan')): ?>
				loadKecamatan();
			<?php endif; ?>
		})
	}
	function loadKecamatan() {
		var id_kabupaten = $('#select-id-kabupaten').val();
		var id_kecamatan = "<?php echo e(g('id_kecamatan')); ?>";
		$.get("<?php echo e(action('AdminDashboardController@getAjaxKecamatan')); ?>?id_kabupaten="+id_kabupaten+"&id_kecamatan="+id_kecamatan,function(r) {
			var opt = "<option value=''>Semua Kecamatan</option>";
			$.each(r,function(i,o) {
				var select = (o.selected==true)?"selected":"";
				opt += "<option "+select+" value='"+o.id+"'>"+o.nama+"</option>";
			})
			$("#select-id-kecamatan").html(opt);
			<?php if(g('id_kelurahan')): ?>
				loadKelurahan();
			<?php endif; ?>
		})
	}
	function loadKelurahan() {
		var id_kecamatan = $('#select-id-kecamatan').val();
		var id_kelurahan = "<?php echo e(g('id_kelurahan')); ?>";
		$.get("<?php echo e(action('AdminDashboardController@getAjaxKelurahan')); ?>?id_kecamatan="+id_kecamatan+"&id_kelurahan="+id_kelurahan,function(r) {
			var opt = "<option value=''>Semua Kelurahan / Desa</option>";
			$.each(r,function(i,o) {
				var select = (o.selected==true)?"selected":"";
				opt += "<option "+select+" value='"+o.id+"'>"+o.nama+"</option>";
			})
			$("#select-id-kelurahan").html(opt);
		})
	}
	$(function() {
		<?php if(g('id_kabupaten')): ?>
			loadKecamatan();
		<?php endif; ?>
	})
</script>
<div id='modal-filter-wilayah' class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Filter Wilayah</h4>
      </div>
      <form method="get">
      <div class="modal-body">
        <div class="form-group">
        	<label>Kabupaten / Kota</label> 
        	<select name="id_kabupaten" id="select-id-kabupaten" onchange="loadKecamatan()" class="form-control">
        		<option value="">Semua Kabupaten / Kota</option>
        		<?php $data = getData('kabupaten',$cond="id_provinsi = '$event->id_provinsi'",$limit=null,$orderby='nama asc');?>
        		<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        			<option <?php echo e(g('id_kabupaten')==$d->id?"selected":""); ?> value="<?php echo e($d->id); ?>"><?php echo e($d->nama); ?></option>
        		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>      		
        	</select>
        </div>
        <div class="form-group">
        	<label>Kecamatan</label> 
        	<select name="id_kecamatan" id="select-id-kecamatan" class="form-control">
        		<option value="">Semua Kecamatan</option>        		
        	</select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Filter</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $__env->stopPush(); ?>


<div class="row">
	<div class="col-sm-12">
		<?php 
			$labelWilayah = "Semua Wilayah";
			if(g('id_kabupaten')) {
				$kabupaten = first('kabupaten',g('id_kabupaten'));
				$labelWilayah = "Filter: ".$kabupaten->nama;
				if(g('id_kecamatan')) {
					$kecamatan = first('kecamatan',g('id_kecamatan'));
					$labelWilayah .= " &raquo; ".$kecamatan->nama;
				}
			}
		?>
		<div style="text-align: right;margin-bottom: 10px">
			<a href="javascript:;" onclick="showFilterWilayah()" class="btn btn-primary"><i class="fa fa-filter"></i> <?php echo e($labelWilayah); ?></a>
		</div> 

		<div class="box box-default">
			<div class="box-header"><i class="fa fa-pie-chart"></i> Grafik Interaksi</div>
			<div class="box-body">
				<div class="chart">
			        <div id="chartContainer" style="height: 300px; width: 100%;"></div>
			      </div>

			      <?php 
			      	
			      	$groupPoint = DB::table('member')			      	
			      	->select(DB::raw("(select count(kuisoner.id) from kuisoner where id_member = member.id and kuisoner.id_event = '$event->id') + (select count(distribusi.id) from distribusi where id_member = member.id and distribusi.id_event = '$event->id') as total_point"),DB::raw("COUNT(member.id) as jumlah_member"))
			      	->groupBy("total_point")
			      	->orderby("total_point","asc");
			      	if(g('id_kabupaten')) {
			      		$groupPoint->where('member.id_kabupaten',g('id_kabupaten'));
			      	}
			      	if(g('id_kecamatan')) {
			      		$groupPoint->where('member.id_kecamatan',g('id_kecamatan'));
			      	}
			      	

			      	$dataSet = [];
			      	foreach($groupPoint->get() as $p) {
			      		$dataSet[] = [
			      			'label'=>$p->total_point,
			      			'y'=>$p->jumlah_member
			      		];
			      	}
			      ?>

			      <?php $__env->startPush('bottom'); ?>

					<script>
						function onClickInteraksi(e) {
							// alert(  e.dataSeries.type + ", dataPoint { x:" + e.dataPoint.x + ", y: "+ e.dataPoint.y + " }" );
							console.log(e.dataPoint);
							location.href = "<?php echo e(action('AdminDashboardController@getAnggota')); ?>?id_event=<?php echo e($event->id); ?>&point="+e.dataPoint.label+"&id_kabupaten=<?php echo e(g('id_kabupaten')); ?>&id_kecamatan=<?php echo e(g('id_kecamatan')); ?>";
						}
					window.onload = function () {
						$("#chartContainer").CanvasJSChart({
							title: {
								text: "Grafik Interaksi"              
							},
							data: [              
							{
								// Change type to "doughnut", "line", "splineArea", etc.
								type: "column",
								click: onClickInteraksi,
								dataPoints: <?php echo json_encode($dataSet); ?>

							}
							]
						});
					}
					</script>
				
										
			      <?php $__env->stopPush(); ?>
		
			</div>
		</div>



		<div class="box box-default">
			<div class="box-header"><i class="fa fa-pie-chart"></i> Grafik Persebaran Anggota</div>
			<div class="box-body">
				<div class="chart">
			        <div id="chartWilayah" style="height: 300px; width: 100%;"></div>
			      </div>

			      <?php 
			      	

			      	$title = null;
			      	if(g('id_kabupaten') && !g('id_kecamatan')) {
			      		$kab = CRUDBooster::first('kabupaten',g('id_kabupaten'));
			      		$title = "Wilayah Kabupaten ".$kab->nama;

			      		$kecamatan = DB::table('kecamatan')
			      		->where('id_kabupaten',g('id_kabupaten'))			      		
				      	->select('*',DB::raw("(select count(member.id) from member where id_kecamatan = kecamatan.id) as total"))
				      	->orderby('nama','asc')->get();
				      	$dataset = [];
				      	foreach($kecamatan as $k) {
				      		$dataset[] = ['label'=>'Kec. '.$k->nama,'y'=>$k->total,'id_kabupaten'=>$k->id_kabupaten,'id_kecamatan'=>$k->id,'id_desa'=>''];
				      	}
				      	$linkBack = action('AdminDashboardController@getIndex').'#chartWilayah';
				    }elseif (g('id_kabupaten') && g('id_kecamatan')) {
				    	$kab = CRUDBooster::first('kecamatan',g('id_kecamatan'));
			      		$title = "Wilayah Kecamatan ".$kab->nama;

			      		$desa = DB::table('desa')
			      		->where('id_kabupaten',g('id_kabupaten'))
			      		->where('id_kecamatan',g('id_kecamatan'))
				      	->select('*',DB::raw("(select count(member.id) from member where id_desa = desa.id) as total"))
				      	->orderby('nama','asc')->get();
				      	$dataset = [];
				      	foreach($desa as $k) {
				      		$dataset[] = ['label'=>'Desa. '.$k->nama,'y'=>$k->total,'id_kabupaten'=>$k->id_kabupaten,'id_kecamatan'=>$k->id_kecamatan,'id_desa'=>$k->id];
				      	}
				    	$linkBack = action('AdminDashboardController@getIndex').'?id_event='.g('id_event').'&id_kabupaten='.g('id_kabupaten').'#chartWilayah';
			      	}else{

			      		$kabupaten = DB::table('kabupaten')
				      	->select('*',DB::raw("(select count(member.id) from member where id_kabupaten = kabupaten.id) as total"))
				      	->orderby('nama','asc')->get();
				      	$dataset = [];
				      	foreach($kabupaten as $k) {
				      		$dataset[] = ['label'=>$k->nama,'y'=>$k->total,'id_kabupaten'=>$k->id,'id_kecamatan'=>'','id_desa'=>''];
				      	}
			      		$title = "Semua Wilayah Kabupaten";
			      	}
			      ?>

			      <?php if($linkBack): ?>
			      <br/>
			      	<p>
			      		<a href="<?php echo e($linkBack); ?>" class="btn btn-primary">&laquo; Kembali</a>
			      	</p>
			      <?php endif; ?>

			      <?php $__env->startPush('bottom'); ?>
			      	<style type="text/css">
			      		.canvasjs-chart-credit {
			      			display: none
			      		}
			      	</style>
					<script>
						function onClick(e) {
							console.log(e.dataPoint);
							location.href = "<?php echo e(action('AdminDashboardController@getIndex')); ?>?id_event=<?php echo e($event->id); ?>&id_kabupaten="+e.dataPoint.id_kabupaten+'&id_kecamatan='+e.dataPoint.id_kecamatan+'&gw_id_desa='+e.dataPoint.id_desa+'#chartWilayah';
						}
					$(function() {
						$("#chartWilayah").CanvasJSChart({
							title: {
								text: "<?php echo e($title); ?>"              
							},
							data: [              
							{								
								type: "column",
								click: onClick,
								dataPoints: <?php echo json_encode($dataset); ?>

							}
							]
						});
					})									
					</script>
				
										
			      <?php $__env->stopPush(); ?>
		
			</div>
		</div>


	</div><!--end-col-sm-6-->
	
</div>



<div class="box box-default">
	<div class="box-header"><i class="fa fa-pie-chart"></i> Grafik Kuisoner</div>
	<div class="box-body">
		
		<?php

			$totalJawabanAll = DB::table('kuisoner')	
			->where('id_event',getEventIdActive())
			->count();

			$soal = DB::table('soal')
			->whereNull('deleted_at')
			->where('id_event',getEventIdActive())
			->orderby('urutan','asc')->get();
		?>
			
			<?php $__currentLoopData = $soal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				

					<?php if($s->tipe!='Text'): ?>
					<?php
						$soalJawaban = DB::table('soal_jawaban')
						->whereNull('deleted_at')
						->where('id_soal',$s->id)
						->get();
						$dataSet = [];
						foreach($soalJawaban as $sj) {
							$totalJawaban = DB::table('kuisoner_detail')
							->join('kuisoner','kuisoner.id','=','id_kuisoner')
							->join('member','member.id','=','kuisoner.id_member')
							->where('id_soal',$s->id)
							->where('id_soal_jawaban',$sj->id);

							if(g('id_kecamatan')) $totalJawaban->where('member.id_kecamatan',g('id_kecamatan'));
							if(g('id_kabupaten')) $totalJawaban->where('member.id_kabupaten',g('id_kabupaten'));
								
							$totalJawaban = $totalJawaban->count();
							@$percent = round($totalJawaban/$totalJawabanAll*100,2);
							$dataSet[] = ['y'=>$percent,'label'=>$percent.'%','indexLabel'=>$sj->jawaban];
						}
						
								
					?>
												
					
							<div id="chartJawaban<?php echo e($s->id); ?>" style="width: 100%; height: 200px"></div>

							<?php $__env->startPush('bottom'); ?>
								<script>
							//Better to construct options first and then pass it as a parameter
							var options3 = {
								animationEnabled: true,
								title: {
									text: "<?php echo e($s->isi); ?>",                
									fontColor: "Peru"
								},	
								axisY: {
									tickThickness: 0,
									lineThickness: 0,
									valueFormatString: " ",
									gridThickness: 0                    
								},
								axisX: {
									tickThickness: 0,
									lineThickness: 0,
									labelFontSize: 18,
									labelFontColor: "Peru"				
								},
								data: [{
									indexLabelFontSize: 24,
									toolTipContent: "<span style=\"color:#62C9C3\">{indexLabel}:</span> <span style=\"color:#CD853F\"><strong>{y}</strong></span>",
									indexLabelPlacement: "inside",
									indexLabelFontColor: "white",
									indexLabelFontWeight: 400,
									indexLabelFontFamily: "Verdana",
									color: "#62C9C3",
									type: "bar",

									dataPoints: <?php echo json_encode($dataSet); ?>

								}]
							};

		

							$("#chartJawaban<?php echo e($s->id); ?>").CanvasJSChart(options3);
							</script>
							<?php $__env->stopPush(); ?>



					<?php else: ?>
						
						<?php

							if(g('id_kecamatan')) {
								$filterKecamatan = " and member.id_kecamatan = '".g('id_kecamatan')."'";
							}else{
								$filterKecamatan = "";
							}

							$groupText = DB::table('kuisoner_detail')
							->join('soal','soal.id','=','id_soal')
							->where('soal.tipe','Text')
							->where('id_soal',$s->id)
							->where('keterangan','!=','')
							->select('keterangan',DB::raw("(SELECT count(b.id) from kuisoner_detail as b join kuisoner on kuisoner.id = b.id_kuisoner join member on member.id = kuisoner.id_member where b.id_soal = kuisoner_detail.id_soal and b.keterangan = kuisoner_detail.keterangan $filterKecamatan) as jumlah"))
							->groupBy('keterangan')
							->orderby('jumlah','desc')
							->take(5)
							->get();
							$dataSet = [];
							foreach($groupText as $g) {
									$totalJawaban = $g->jumlah;
									@$percent = round($totalJawaban/$totalJawabanAll*100,2);	
									$dataSet[] = ['y'=>$percent,'label'=>$percent.'%','indexLabel'=>$g->keterangan];								
							}
						?>

						<div id="chartJawaban<?php echo e($s->id); ?>" style="width: 100%; height: 200px"></div>

							<?php $__env->startPush('bottom'); ?>
								<script>
							//Better to construct options first and then pass it as a parameter
								var options2 = {
									animationEnabled: true,
									title: {
										text: "<?php echo e($s->isi); ?>",                
										fontColor: "Peru"
									},	
									axisY: {
										tickThickness: 0,
										lineThickness: 0,
										valueFormatString: " ",
										gridThickness: 0                    
									},
									axisX: {
										tickThickness: 0,
										lineThickness: 0,
										labelFontSize: 18,
										labelFontColor: "Peru"				
									},
									data: [{
										indexLabelFontSize: 24,
										toolTipContent: "<span style=\"color:#62C9C3\">{indexLabel}:</span> <span style=\"color:#CD853F\"><strong>{y}</strong></span>",
										indexLabelPlacement: "inside",
										indexLabelFontColor: "white",
										indexLabelFontWeight: 400,
										indexLabelFontFamily: "Verdana", 
										color: "#62C9C3", 
										type: "bar",
			
										dataPoints: <?php echo json_encode($dataSet); ?>

									}]
								};

	
								$("#chartJawaban<?php echo e($s->id); ?>").CanvasJSChart(options2);
							</script>
							<?php $__env->stopPush(); ?>
					<?php endif; ?>
				
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			
		
	</div>
</div>





<script src="http://maps.google.com/maps/api/js?sensor=false" 
          type="text/javascript"></script>

<div style="text-align: right;margin-bottom: 10px">
	<form id="form-filter-map" method="get">
		<input type="hidden" name="id_kecamatan" value="<?php echo e(g('id_kecamatan')); ?>">
	<select onchange="$('#form-filter-map').submit()" name="jenis_map" style="padding: 5px">
		<option value="">** Filter Jenis Data</option>
		<option <?php echo e(g('jenis_map')=='Red'?'selected':''); ?> value="Red">Red (Point 0 ~ 5)</option>		
		<option <?php echo e(g('jenis_map')=='Yellow'?'selected':''); ?> value="Yellow">Yellow (Point 6 ~ 10)</option>		
		<option <?php echo e(g('jenis_map')=='Green'?'selected':''); ?> value="Green">Green (Point 11 ~ 20)</option>		
		<option <?php echo e(g('jenis_map')=='Blue'?'selected':''); ?> value="Blue">Blue (Point >= 21)</option>		
	</select>
	</form>
</div>      

<div class="box box-default">
	<div class="box-header"><i class="fa fa-map-marker"></i> Monitoring Survey</div>
	<div class="box-body" style="padding: 0 0 0 0">
		<div id="map" style="width: 100%; height: 400px;"></div>
	</div>
</div>        

<?php $__env->startPush('bottom'); ?>
<script type="text/javascript">

var map = new google.maps.Map(document.getElementById('map'), {
  zoom: 9,
  center: new google.maps.LatLng( <?php echo e($event->latitude); ?>, <?php echo e($event->longitude); ?>),
  mapTypeId: google.maps.MapTypeId.ROADMAP
});

var infowindow = new google.maps.InfoWindow();

var markers = [];
var bounds = new google.maps.LatLngBounds();

function loadMarker() {
	$.get("<?php echo e(action('AdminDashboardController@getLoadMarker')); ?>?jenis=<?php echo e(g('jenis_map')); ?>&id_event=<?php echo e($event->id); ?>&id_kecamatan=<?php echo e(g('id_kecamatan')); ?>&id_kabupaten=<?php echo e(g('id_kabupaten')); ?>",function(r) {
		var e = 0;
		$.each(r,function(i,o) {
			var image = {
	          url: o.marker,	          
	          size: new google.maps.Size(48, 48),	          
	          origin: new google.maps.Point(0, 0),	          
	          anchor: new google.maps.Point(0, 32)
	        };
	      var loc = new google.maps.LatLng(o.latitude, o.longitude);
		  var marker = new google.maps.Marker({
		    position: loc,
		    map: map,
		    icon: image,
		    title: o.nama+' / Point: '+o.total_point
		  });
		  markers.push(marker);		  
		  // bounds.extend(loc);

		  google.maps.event.addListener(marker, 'click', (function(marker, e) {
		    return function() {
		      infowindow.setContent(
		      	"<div style='width:400px'>"+
		      	"<table class='table table-striped'>"+		      			      	
		      	"<tr><td>Tanggal Register</td><td>"+o.created_at+"</td></tr>"+		  
		      	"<tr><td>Nama Anggota</td><td>"+o.nama+"</td></tr>"+		  
		      	"<tr><td>NIK</td><td>"+o.no_ktp+"</td></tr>"+		  
		      	"<tr><td>KTA</td><td>"+o.no_kta+"</td></tr>"+		  
		      	"</table>"+
		      	"</div>"
		      	);
		      infowindow.open(map, marker);
		    }
		  })(marker, e));
		  e += 1;
		})

		// map.fitBounds(bounds);
    	// map.panToBounds(bounds);
	})
}

function clearMarker() {
	for (var i = 0; i < markers.length; i++) {
      markers[i].setMap(null);
    }
}

loadMarker();
</script>
<?php $__env->stopPush(); ?>










<?php $__env->stopSection(); ?>
<?php echo $__env->make('crudbooster::admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>