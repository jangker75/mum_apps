
<?php $__env->startSection('content'); ?>
<script src="http://maps.google.com/maps/api/js?sensor=false" 
          type="text/javascript"></script>
<?php
if(empty(Request::input('id_event'))) {
	header("Location: http://crocodic.net/survey-apps/public/admin?id_event=1");
}
?>
<div style="text-align: right;margin-bottom: 10px">
	<form id="form-filter" method="get">
	<select onchange="$('#form-filter').submit()" name="id_event" style="padding: 5px">
		<option value="">** Filter By Event</option>
		<?php 
			$event = DB::table('event')->whereNull('deleted_at')->orderby('nama','asc')->get();

		?>
		<?php $__currentLoopData = $event; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<option <?php echo e(g('id_event')==$e->id?"selected":""); ?> value="<?php echo e($e->id); ?>"><?php echo e($e->nama); ?></option>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</select>
	</form>
</div>      

<div class="panel panel-default">
	<div class="panel-heading"><i class="fa fa-map-marker"></i> Monitoring Survey</div>
	<div class="panel-body" style="padding: 0 0 0 0">
		<div id="map" style="width: 100%; height: 400px;"></div>
	</div>
</div>        

<?php $__env->startPush('bottom'); ?>
<script type="text/javascript">

var map = new google.maps.Map(document.getElementById('map'), {
  zoom: 5,
  center: new google.maps.LatLng(-1.4413043, 117.4620465),
  mapTypeId: google.maps.MapTypeId.ROADMAP
});

var infowindow = new google.maps.InfoWindow();

var markers = [];

function loadMarker() {
	$.get("<?php echo e(action('AdminDashboardController@getLoadMarker')); ?>?id_event=<?php echo e(g('id_event')); ?>",function(r) {
		var e = 0;
		$.each(r,function(i,o) {
		  var marker = new google.maps.Marker({
		    position: new google.maps.LatLng(o.latitude, o.longitude),
		    map: map
		  });
		  markers.push(marker);		  

		  google.maps.event.addListener(marker, 'click', (function(marker, e) {
		    return function() {
		      infowindow.setContent(
		      	"<div style='width:400px'>"+
		      	"<table class='table table-striped'>"+
		      	"<tr><td width='50%'>No. Kuisoner</td><td>"+o.no_kuisoner+"</td></tr>"+
		      	"<tr><td>Surveyor</td><td>"+o.surveyor_nama+"</td></tr>"+
		      	"<tr><td>Waktu</td><td>"+o.kuisoner_datetime+"</td></tr>"+
		      	"<tr><td>Nama Responden</td><td>"+o.nama_responden+"</td></tr>"+
		      	"<tr><td>No HP Responden</td><td>"+o.no_hp_responden+"</td></tr>"+
		      	"<tr><td>Nama KK</td><td>"+o.nama_kk+"</td></tr>"+
		      	"<tr><td>RT</td><td>"+o.rt+"</td></tr>"+
		      	"<tr><td>RW</td><td>"+o.rw+"</td></tr>"+
		      	"<tr><td>Desa/Kelurahan</td><td>"+o.desa_kelurahan+"</td></tr>"+
		      	"<tr><td>Kecamatan</td><td>"+o.Kecamatan+"</td></tr>"+
		      	"<tr><td>Kabupaten Kota</td><td>"+o.kabupaten_kota+"</td></tr>"+
		      	"<tr><td>TTD Responden</td><td><img width='90px' height='90px' src='<?php echo e(asset('/')); ?>/"+o.ttd_responden+"'/></td></tr>"+
		      	"<tr><td>Foto 1</td><td><img width='90px' height='90px' src='<?php echo e(asset('/')); ?>/"+o.photo1+"'/></td></tr>"+
		      	"<tr><td>Foto 2</td><td><img width='90px' height='90px' src='<?php echo e(asset('/')); ?>/"+o.photo2+"'/></td></tr>"+
		      	"<tr><td>Foto 3</td><td><img width='90px' height='90px' src='<?php echo e(asset('/')); ?>/"+o.photo3+"'/></td></tr>"+
		      	"</table>"+
		      	"</div>"
		      	);
		      infowindow.open(map, marker);
		    }
		  })(marker, e));
		  e += 1;
		})
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

<div class="panel panel-default">
	<div class="panel-heading"><i class="fa fa-pie-chart"></i> Realisasi Target Event</div>
	<div class="panel-body">
		<div class="chart">
	        <canvas id="barChart" style="height:230px"></canvas>
	      </div>

	      <?php 
	      	$data = DB::table('event');
	      	$data->whereNull('deleted_at');
			if(g('id_event')) {
				$data->where('id',g('id_event'));
			}
			$data->select('event.*',DB::raw("(select count(id) from kuisoner where deleted_at is null and id_event = event.id) as realisasi"));
			$data = $data->get();
			$labels = [];
			$targets = [];
			$reals = [];
			foreach($data as $d) {
				$labels[] = $d->nama;
				$targets[] = $d->target;
				$reals[] = $d->realisasi;
			}
	      ?>

	      <?php $__env->startPush('bottom'); ?>
	      <!-- ChartJS -->
		  <script src="<?php echo e(asset('vendor/crudbooster/assets/adminlte/plugins/chartjs/Chart.js')); ?>"></script>

	      <script type="text/javascript">
	      	var areaChartData = {
		      labels  : <?php echo json_encode($labels); ?>,
		      datasets: [
		        {
		          label               : 'Target',
		          fillColor           : 'rgba(210, 214, 222, 1)',
		          strokeColor         : 'rgba(210, 214, 222, 1)',
		          pointColor          : 'rgba(210, 214, 222, 1)',
		          pointStrokeColor    : '#c1c7d1',
		          pointHighlightFill  : '#fff',
		          pointHighlightStroke: 'rgba(220,220,220,1)',
		          data                : <?php echo json_encode($targets); ?>

		        },
		        {
		          label               : 'Realisasi',
		          fillColor           : 'rgba(60,141,188,0.9)',
		          strokeColor         : 'rgba(60,141,188,0.8)',
		          pointColor          : '#3b8bba',
		          pointStrokeColor    : 'rgba(60,141,188,1)',
		          pointHighlightFill  : '#fff',
		          pointHighlightStroke: 'rgba(60,141,188,1)',
		          data                : <?php echo json_encode($reals); ?>

		        }
		      ]
		    }
	      	//-------------
		    //- BAR CHART -
		    //-------------
		    var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
		    var barChart                         = new Chart(barChartCanvas)
		    var barChartData                     = areaChartData
		    barChartData.datasets[1].fillColor   = '#00a65a'
		    barChartData.datasets[1].strokeColor = '#00a65a'
		    barChartData.datasets[1].pointColor  = '#00a65a'
		    var barChartOptions                  = {		      
		      scaleBeginAtZero        : true,		      
		      scaleShowGridLines      : true,		      
		      scaleGridLineColor      : 'rgba(0,0,0,.05)',		      
		      scaleGridLineWidth      : 1,		      
		      scaleShowHorizontalLines: true,		      
		      scaleShowVerticalLines  : true,		      
		      barShowStroke           : true,		      
		      barStrokeWidth          : 2,		      
		      barValueSpacing         : 5,		      
		      barDatasetSpacing       : 1,		      
		      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>" title="<%=datasets[i].label%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',		      
		      responsive              : true,
		      maintainAspectRatio     : true
		    }

		    barChartOptions.datasetFill = false
		    barChart.Bar(barChartData, barChartOptions)
	      </script>
	      <?php $__env->stopPush(); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th width="25px">No</th>
					<th>Nama Event</th>
					<th width="200px">Target</th>
					<th width="200px">Realisasi</th>
					<th width="200px">Persentase</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					
					foreach($data as $d):

				?>
					<tr>
						<td><?php echo e(++$no); ?></td>
						<td><?php echo e($d->nama); ?></td>
						<td><?php echo e($d->target); ?></td>
						<td><?php echo e($d->realisasi); ?></td>
						<td><?php echo e(round($d->realisasi/$d->target*100,2)); ?> %</td>
					</tr>
				<?php endforeach;?>
			</tbody>

		</table>		
	</div>
</div>


<div class="panel panel-default">
	<div class="panel-heading"><i class="fa fa-pie-chart"></i> Grafik Kuisoner</div>
	<div class="panel-body">
		<?php if(g('id_event')): ?>
		<?php 
			$totalJawabanAll = DB::table('kuisoner')			
			->where('kuisoner.id_event',g('id_event'))
			->count();

			$soal = DB::table('soal')
			->whereNull('deleted_at')
			->where('id_event',g('id_event'))
			->orderby('urutan','asc')->get();
		?>
			<ol>
			<?php $__currentLoopData = $soal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<li>
					<strong><?php echo e($s->isi); ?></strong>

					<?php if($s->tipe!='Text'): ?>
					<?php
						$soalJawaban = DB::table('soal_jawaban')
						->whereNull('deleted_at')
						->where('id_soal',$s->id)
						->get();
					?>
					<ol>
					<?php $__currentLoopData = $soalJawaban; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li>
							
							<?php 
								$totalJawaban = DB::table('kuisoner_detail')
								->where('id_soal',$s->id)
								->where('id_soal_jawaban',$j->id)
								->count();
								@$percent = $totalJawaban/$totalJawabanAll*100;
								if($percent>=0 && $percent<25) {
									$color = 'red';
								}elseif ($percent >= 25 && $percent < 50) {
									$color = 'yellow';
								}elseif ($percent >= 50 && $percent < 75) {
									$color = 'aqua';
								}elseif ($percent >= 75 && $percent <= 100) {
									$color = 'green';
								}
							?>
							<?php echo e($j->jawaban); ?> <strong>(<?php echo e(round($percent)); ?>%)</strong> <?php echo e($totalJawaban); ?> / <?php echo e($totalJawabanAll); ?>

							<div class="progress">
				                <div class="progress-bar progress-bar-<?php echo e($color); ?>" style="width: <?php echo e(round($percent)); ?>%">
				                  <span class="sr-only"><?php echo e($j->jawaban); ?> </span>
				                </div>
				              </div>				              
						</li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</ol>
					<?php else: ?>
						<ol>
						<?php 
							$groupText = DB::table('kuisoner_detail')
							->join('soal','soal.id','=','id_soal')
							->where('soal.tipe','Text')
							->where('id_soal',$s->id)
							->where('keterangan','!=','')
							->select('keterangan',DB::raw("(SELECT count(b.id) from kuisoner_detail as b where b.id_soal = kuisoner_detail.id_soal and b.keterangan = kuisoner_detail.keterangan) as jumlah"))
							->groupBy('keterangan')
							->orderby('jumlah','desc')
							->take(5)
							->get();
							foreach($groupText as $g):
						?>
							<li>								
								<?php 
									$totalJawaban = $g->jumlah;
									@$percent = $totalJawaban/$totalJawabanAll*100;
									if($percent>=0 && $percent<25) {
										$color = 'red';
									}elseif ($percent >= 25 && $percent < 50) {
										$color = 'yellow';
									}elseif ($percent >= 50 && $percent < 75) {
										$color = 'aqua';
									}elseif ($percent >= 75 && $percent <= 100) {
										$color = 'green';
									}
								?>
								<?php echo e($g->keterangan); ?> <strong>(<?php echo e(round($percent)); ?>%)</strong> <?php echo e($totalJawaban); ?> / <?php echo e($totalJawabanAll); ?>

								<div class="progress">
					                <div class="progress-bar progress-bar-<?php echo e($color); ?>" style="width: <?php echo e(round($percent)); ?>%">
					                  <span class="sr-only"><?php echo e($g->keterangan); ?> </span>
					                </div>
					              </div>
							</li>
						<?php endforeach;?>
						</ol>
					<?php endif; ?>
				</li>	
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ol>
		<?php else: ?>
			<em>~ Silahkan pilih event terlebih dahulu ~</em>
		<?php endif; ?>
	</div>
</div>





<?php $__env->stopSection(); ?>
<?php echo $__env->make('crudbooster::admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>