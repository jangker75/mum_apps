<?php $__env->startSection('content'); ?>
	
	<p>
		<a href="<?php echo e(action('AdminDashboardController@getIndex')); ?>" class="btn btn-default">Kembali</a>
	</p>
	<div class="box box-primary">
		<div class="box-header">
			Anggota
		</div>
		<div class="box-body">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Nama</th>
						<th>KTP</th>
						<th>KTA</th>
						<th>Jenis Kelamin</th>
						<th>Kecamatan</th>						
					</tr>
				</thead>
				<tbody>
					<?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td><?php echo e($row->nama); ?></td>
						<td><?php echo e($row->no_ktp); ?></td>
						<td><?php echo e($row->no_kta); ?></td>
						<td><?php echo e($row->jenis_kelamin); ?></td>
						<td><?php echo e($row->kecamatan_nama); ?></td>
					</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tbody>
			</table>

			<p>
				<?php echo $result->appends(Request::except('page'))->links(); ?>

			</p>
		</div>
	</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('crudbooster::admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>