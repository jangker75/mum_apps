
<?php $__env->startSection('content'); ?>
<div class="box box-primary">
    <div class="box box-body">
        <p>
            <a href="<?php echo e(action('AdminKotaController@getIndex')); ?>" class="btn btn-xs btn-primary">&laquo; Kembali</a>
        </p>
		<div class="panel panel-default">
            <div class="panel-heading">Import Data Kota/Kabupaten</div>
			<form method="post" enctype="multipart/form-data" action="">
				<?php echo csrf_field(); ?>
			<div class="panel-body">
				
				<div class="form-group">
					<label>File XLS</label>
					<input type="file" class="form-control" required name="userfile">
					<div class="help-block">
						File format .xls, .xlsx. Unduh format template <a href="<?php echo e(asset('format_import/format import kota kabupaten.xlsx')); ?>" target="_blank">Klik disini</a>
					</div>
				</div>

			</div>
			<div class="panel-footer">
				<input type="submit" class="btn btn-primary" value="Import">
			</div>
			</form>
        </div>		
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('crudbooster::admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>