<?php $__env->startSection('content'); ?>

<?php 
	$event = getMapsActive();
?>
<div class="row">

<div class="col-md-3 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-yellow"><i class="fa fa-pencil"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Jumlah Client</span>
      <span class="info-box-number">
      <?php echo e($countClient); ?>

      	</span>
        <a href="<?php echo e(CRUDBooster::adminPath('client')); ?>" class="small-box-footer">
          Detail... <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
  
  </div>
</div> 

<div class="col-md-3 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-yellow"><i class="fa fa-pencil"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Jumlah Lokasi Tenant</span>
      <span class="info-box-number">
      <?php echo e($countLokasiTenant); ?>

      </span>
      <a href="<?php echo e(CRUDBooster::adminPath('tenant')); ?>" class="small-box-footer">
        Detail... <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>

  </div>

</div>

 <div class="col-md-3 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-yellow"><i class="fa fa-pencil"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Jumlah User</span>
      <span class="info-box-number">
      <?php echo e($countUser); ?>

      </span>
      <a href="<?php echo e(CRUDBooster::adminPath('user')); ?>" class="small-box-footer">
        Detail... <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>

  </div>
</div>

<div class="col-md-3 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-yellow"><i class="fa fa-pencil"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">User Menunggu Approve</span>
      <span class="info-box-number">
      <?php echo e($countNewUser); ?>

      </span>
      <a href="<?php echo e(CRUDBooster::adminPath('user?q=pending')); ?>" class="small-box-footer">
        Detail... <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>

  </div>

</div>

</div>



<div class="col-sm-12">
  <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">10 Laporan Visit Terbaru</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body">
       <div class="table-responsive">
          <table class="table no-margin">
            <thead>
            <tr>
              <th>Tanggal</th>
              <th>Nama</th>
              <th>Client</th>
              <th>Nama Tenant</th>
              <th>Area</th>
              <th>Status</th>
              <th>Detail</th>
            </tr>
            </thead>
            
            <tbody>
            <?php $__currentLoopData = $visitTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
              <tr>
                <td><?php echo e(date('d M Y H:i',strtotime($row->created_at))); ?></td>
                <td><?php echo e($row->nama_user); ?></td>
                <td><?php echo e($row->nama_client); ?></td>
                <td><?php echo e($row->nama_tenant); ?></td>
                <td><?php echo e($row->area_tenant); ?></td>
                <td>
                <?php if($row->status_radius_visit == "In Range"): ?>
                  <span class="label label-success"><?php echo e($row->status_radius_visit); ?></span>
                <?php else: ?>
                  <span class="label label-danger"><?php echo e($row->status_radius_visit); ?></span>
                <?php endif; ?>
                </td>
                <td>
                  <a class="btn btn-xs btn-primary btn-detail" title="Detail Data" href="<?php echo e(CRUDBooster::adminPath('lacak/detail')); ?>/<?php echo e($row->id); ?>"><i class="fa fa-eye"></i></a>
                </td>
              </tr>


              
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            </tbody>
          </table>
          <hr>
          
      </div>
      </div>

    </div> 
  </div>
  
  
<?php if(CRUDBooster::isSuperadmin() || CRUDBooster::myPrivilegeId()=='3'): ?>
<div style="text-align: right;margin-bottom: 10px">
  <form id="form-filter-map" method="get">
  
  <select onchange="$('#form-filter-map').submit()" name="jenis_map" style="padding: 5px">
  <option value="">** Filter Jenis Data</option>
  <option <?php echo e(g('jenis_map')=='Green'?'selected':''); ?> value="Green">In Range (<=50 Meters)</option>		
  <option <?php echo e(g('jenis_map')=='Red'?'selected':''); ?> value="Red">Out of Range (>50 Meters)</option>		
  
  
  </select>
  </form>
  </div>

   <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Monitoring Visit Today</h3> 
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    <div class="box-body" style="padding: 0 0 0 0">
      <div id="map" style="width: 100%; height: 400px;"></div>
    </div>
  </div>  




<?php endif; ?>


<?php $__env->startPush('bottom'); ?>
    

<script src="http://maps.google.com/maps/api/js?key=<?php echo e(CRUDBooster::getSetting('google_api_key')); ?>" 
type="text/javascript"></script>
<script type="text/javascript">

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 13,
    center: new google.maps.LatLng( <?php echo e($event->latitude); ?>, <?php echo e($event->longitude); ?>),
    // center: new google.maps.LatLng( <?php echo e($event->latitude); ?>, <?php echo e($event->longitude); ?>),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  
  var infowindow = new google.maps.InfoWindow();
  
  var markers = [];
  var bounds = new google.maps.LatLngBounds();

  function loadMarkerTenant() {
    $.get("<?php echo e(action('AdminDashboardController@getTenantMarker')); ?>",function(r) {
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
          title: o.nama
        });
        markers.push(marker);		  
        // bounds.extend(loc);
  
        google.maps.event.addListener(marker, 'click', (function(marker, e) {
          return function() {
            infowindow.setContent(
              "<div style='width:400px'>"+
              "<table class='table table-striped'>"+		      			      	
              "<tr><td>Nama Client</td><td>"+o.nama_client+"</td></tr>"+		  
              "<tr><td>Nama Tempat</td><td>"+o.nama+"</td></tr>"+		  
              "<tr><td>Nama Area</td><td>"+o.alamat+"</td></tr>"+	  
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
  function loadMarker() {
    $.get("<?php echo e(action('AdminDashboardController@getLoadMarker')); ?>?jenis=<?php echo e(g('jenis_map')); ?>",function(r) {
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
          title: o.nama
        });
        markers.push(marker);		  
        // bounds.extend(loc);
  
        google.maps.event.addListener(marker, 'click', (function(marker, e) {
          return function() {
            infowindow.setContent(
              "<div style='width:400px'>"+
              "<table class='table table-striped'>"+		      			      	
              "<tr><td>Tanggal Scan</td><td>"+o.tanggal_scan+"</td></tr>"+		  
              "<tr><td>Waktu Scan</td><td>"+o.waktu_scan+"</td></tr>"+		  
              "<tr><td>Nama Anggota</td><td>"+o.nama_user+"</td></tr>"+		  
              "<tr><td>NIK</td><td>"+o.no_ktp+"</td></tr>"+		  
              "<tr><td>Nama Client</td><td>"+o.nama_client+"</td></tr>"+		  
              "<tr><td>Nama Tempat</td><td>"+o.nama_tenant+"</td></tr>"+		  
              "<tr><td>Area Visit</td><td>"+o.area_tenant+"</td></tr>"+	
              "<tr><td><b>Foto Bukti Visit</b>"+
                "</td>"+
                "<td>"+
                  "<a class='example-image-link' href='"+o.foto_visit+"'"+
                    "data-lightbox='exampler1'><img style='max-width:150px' class='img-in-tabel'"+
                    "src="+o.foto_visit+"></a>"+
                    "</td>"+
                    "</tr>"+	  
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
  loadMarkerTenant();
  </script>

<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('crudbooster::admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>