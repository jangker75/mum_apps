<?php $__env->startSection('content'); ?>
  <!-- Your html goes here -->
  <a href="<?php echo e(CRUDBooster::mainpath($slug=NULL)); ?>"><i class="fa fa-chevron-circle-left">&nbsp;  Back To List Visit</i></a>
  <div class='panel panel-default'>
    <div class='panel-heading'><b><?php echo e($page_title); ?></b></div>
    <div class='panel-body'> 

    <?php 
    $kab=DB::table('provinsi')->where('id',$tenant->provinsi_id)->first();
    $prov=DB::table('kota')->where('id',$tenant->kota_id)->first();
    $product=DB::table('kecamatan')->where('id',$tenant->kecamatan_id)->first();

     ?>  

    <div class="table-responsive">
      <table id="table-detail" class="table table-striped">
        <tbody>
           <tr>
            <td><b>NIK</b></td>
            <td><?php echo e($user->nik); ?></td>
          </tr>
           <tr>
            <td><b>Nama</b></td>
            <td><?php echo e($user->nama); ?></td>
          </tr>
          <tr>
            <td><b>Timescan</b></td>
            <td><?php echo e($data->created_at); ?></td>
          </tr>
          <tr>
            <td><b>Nama Lokasi</b></td>
            <td><?php echo e($tenant->nama); ?></td>
          </tr>
          <tr>
            <td><b>Area</b></td>
            <td><?php echo e($tenant->alamat); ?></td>
          </tr>
           <tr>
            <td><b>Realtime scan location</b></td>
               <?php if($data->latitude!=null && $data->longitude!=null): ?>
              <td>
                <a href="https://www.google.com/maps/search/?api=1&query=<?php echo e($data->latitude); ?>,<?php echo e($data->longitude); ?>" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-map-marker"></i>&nbsp;<?php echo e($tenant->alamat); ?></a></td>
              <?php else: ?>
              <td><a href="javascript:void(0)" onclick="alert('Data Lokasi Tidak Ada')" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-map-marker"></i>&nbsp;<?php echo e($tenant->alamat); ?></a></td>
              <?php endif; ?>
          </tr>
          <tr>
            <td><b>Notes/Keterangan</b></td>
            <td><?php echo e($data->notes); ?></td>
          </tr>
          <tr>
            <td><b>Foto Bukti Visit</b></td>
            <td>
            <a class="example-image-link" href="<?php echo e(asset($data->foto1)); ?>"
              data-lightbox="exampler1"><img style="max-width:150px" class="img-in-tabel"
                  src="<?php echo e(asset($data->foto1)); ?>"></a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('crudbooster::admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>