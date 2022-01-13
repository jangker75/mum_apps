<?php $__env->startSection('content'); ?>
		<div class="row">
			<div class="col-sm-5">
				<div class="panel panel-default">
					<div class="panel-heading">Import Form</div>
					<form method="post" enctype="multipart/form-data">
						<div class="panel-body">
							<div class="form-group">
								<label>Pilih File XLS</label>
								<input type="file" name="userfile" class="form-control">
								File yang didukung XLS,XLSX. Unduh template 
								<a target="_blank" href="<?php echo e(asset('sample_import_relawan.xlsx')); ?>">disini</a>
							</div>
						</div>
						<div class="panel-footer">
							<input type="submit" class="btn btn-primary" value="Import"> 
							<a href="<?php echo e(action('AdminSurveyorController@getIndex')); ?>" class="btn btn-default">Kembali</a>
						</div>
					</form>
				</div>				
			</div>
		</div>
				
<?php $__env->stopSection(); ?>
<?php echo $__env->make('crudbooster::admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>