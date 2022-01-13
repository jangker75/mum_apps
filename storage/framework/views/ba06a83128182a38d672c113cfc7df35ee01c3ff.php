<?php $__env->startSection('content'); ?>
		
	<div class="box box-primary">
		<div class="box-header">
			<h4 style="font-weight: bold">DATA ANGGOTA ( <?php echo e(number_format($totaldata)); ?> )</h4>
		</div>
		<div class="box-body">
			<p>
				<a href="<?php echo e(action('AdminDashboardController@getIndex')); ?>" class="btn btn-xs btn-primary">&laquo; Kembali ke Dashboard</a>
			</p>
			<table class="table table-bordered table-striped" style="background: #fff;box-shadow: 0px 0px 10px #dddddd;margin-bottom: 20px">
				<tr>
					<td colspan="3"><strong>Filter By <i class="fa fa-filter"></i></strong></td>
				</tr>
				<?php if(g('id_event')): ?>
				<tr>
					<td width="20%"><strong>Event</strong></td><td width="10px">:</td><td><?php echo e(first('event',g('id_event'))->nama); ?></td>
				</tr>
				<?php endif; ?>
				<?php if(g('id_kabupaten')): ?>
				<tr>
					<td width="20%"><strong>Kabupaten</strong></td><td width="10px">:</td><td><?php echo e(first('kabupaten',g('id_kabupaten'))->nama); ?></td>
				</tr>
				<?php endif; ?>
				<?php if(g('id_kecamatan')): ?>
				<tr>
					<td width="20%"><strong>Kecamatan</strong></td><td width="10px">:</td><td><?php echo e(first('kecamatan',g('id_kecamatan'))->nama); ?></td>
				</tr>
				<?php endif; ?>
				<?php if(g('id_soal')): ?>
				<tr>
					<td width="20%"><strong>Soal</strong></td><td width="10px">:</td><td><?php echo e(first('soal',g('id_soal'))->isi); ?></td>
				</tr>
				<?php endif; ?>
				<?php if(g('id_soal_jawaban')): ?>
				<tr>
					<td width="20%"><strong>Jawaban</strong></td><td width="10px">:</td><td><?php echo e(first('soal_jawaban',g('id_soal_jawaban'))->jawaban); ?></td>
				</tr>
				<?php endif; ?>
				<?php if(g('keterangan')): ?>
				<tr>
					<td width="20%"><strong>Jawaban/Ket</strong></td><td width="10px">:</td><td><?php echo e(g('keterangan')); ?></td>
				</tr>
				<?php endif; ?>
			</table>
			

			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th><a href="<?php echo e(linkSorting('nama')); ?>">NAMA <?php echo sortingIcon('nama'); ?></a></th>
						<th><a href="<?php echo e(linkSorting('no_ktp')); ?>">KTP <?php echo sortingIcon('no_ktp'); ?></a></th>
						<th><a href="<?php echo e(linkSorting('no_kta')); ?>">KTA <?php echo sortingIcon('no_kta'); ?></a></th>
						<th><a href="<?php echo e(linkSorting('jenis_kelamin')); ?>">JENIS KELAMIN <?php echo sortingIcon('jenis_kelamin'); ?></a></th>
						<th><a href="<?php echo e(linkSorting('kecamatan_nama')); ?>">KECAMATAN <?php echo sortingIcon('kecamatan_nama'); ?></a></th>						
						<th><a href="<?php echo e(linkSorting('desa_nama')); ?>">KELURAHAN/DESA <?php echo sortingIcon('desa_nama'); ?></a></th>						
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
						<td><?php echo e($row->desa_nama); ?></td>
					</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tbody>
			</table>

			<p>
				<?php echo $result->appends($_GET)->links(); ?>

			</p>
		</div>
	</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('crudbooster::admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>