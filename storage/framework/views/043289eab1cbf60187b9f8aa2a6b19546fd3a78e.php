<?php $__env->startSection('content'); ?>	
<p>
		<a href="<?php echo e(action('AdminKuisonerController@getIndex')); ?>" class="btn btn-primary">Kembali</a>
	</p>
	<div class="box box-primary">
		<div class="box-body table-responsive">
			<table class="table table-striped">
				<tr>
					<td><strong>No. Survey</strong></td><td>:</td><td><?php echo e($row->no_kuisoner); ?></td>
					<td><strong>Tanggal Survey</strong></td><td>:</td><td><?php echo e($row->created_at); ?></td>
				</tr>
				<tr>
					<td><strong>Nama</strong></td><td>:</td><td><?php echo e($member->nama); ?></td>
					<td><strong>No KTP</strong></td><td>:</td><td><?php echo e($member->no_ktp); ?></td>
				</tr>
				<tr>
					<td><strong>No. KTA</strong></td><td>:</td><td><?php echo e($member->no_kta); ?></td>
					<td><strong>No. KK</strong></td><td>:</td><td><?php echo e($member->no_kk); ?></td>
				</tr>
				<tr>
					<td><strong>Tempat/Tanggal Lahir</strong></td><td>:</td><td><?php echo e($member->tempat_lahir.'/'.$member->tanggal_lahir); ?></td>
					<td><strong>Jenis Kelamin</strong></td><td>:</td><td><?php echo e($member->jenis_kelamin); ?></td>
				</tr>
				<tr>
					<td><strong>Agama</strong></td><td>:</td><td><?php echo e($member->agama); ?></td>
					<td><strong>Pendidikan Terakhir</strong></td><td>:</td><td><?php echo e($member->pendidikan_terakhir); ?></td>
				</tr>
				<tr>
					<td><strong>Pekerjaan</strong></td><td>:</td><td><?php echo e($member->pekerjaan); ?></td>
					<td><strong>Alamat</strong></td><td>:</td><td><?php echo e($member->alamat); ?></td>
				</tr>
				<tr>
					<td><strong>Kota</strong></td><td>:</td><td><?php echo e($member->kota); ?></td>
					<td><strong>Kecamatan</strong></td><td>:</td><td><?php echo e($member->kecamatan); ?></td>
				</tr>
				<tr>
					<td><strong>Desa</strong></td><td>:</td><td><?php echo e($member->desa); ?></td>
					<td><strong>Nomor. HP</strong></td><td>:</td><td><?php echo e($member->nomor_hp); ?></td>
				</tr>
				<tr>
					<td><strong>Email</strong></td><td>:</td><td><?php echo e($member->email); ?></td>
					<td><strong></strong></td><td>:</td><td></td>
				</tr>
				<tr>
					<td><strong>Foto</strong></td><td colspan="5">
						<?php if($row->foto1): ?> <a href="<?php echo e(asset($row->foto1)); ?>" target="_blank"><img src="<?php echo e(asset($row->foto1)); ?>" width="100px" height="100px"></a> <?php endif; ?>						
						<?php if($row->foto2): ?> <a href="<?php echo e(asset($row->foto2)); ?>" target="_blank"><img src="<?php echo e(asset($row->foto2)); ?>" width="100px" height="100px"></a> <?php endif; ?>						
						<?php if($row->foto3): ?> <a href="<?php echo e(asset($row->foto3)); ?>" target="_blank"><img src="<?php echo e(asset($row->foto3)); ?>" width="100px" height="100px"></a> <?php endif; ?>						
					</td>
				</tr>
			</table>

			<table class="table table-striped table-bordered">
				<thead>
					<tr class="active">
						<th>No</th>
						<th>Soal</th>
						<th>Jawaban</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$detail = DB::table('kuisoner_detail')
						->where('id_kuisoner',$row->id)
						->join('soal','soal.id','=','id_soal')
						->join("soal_jawaban","soal_jawaban.id","=","kuisoner_detail.id_soal_jawaban")
						->select("soal.isi","soal_jawaban.jawaban")
						->get();
					?>
					<?php $__currentLoopData = $detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td><?php echo e(++$no); ?></td>
						<td><?php echo e($d->isi); ?></td>
						<td><?php echo e($d->jawaban); ?></td>
					</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tbody>
			</table>
		</div><!--endboxbody-->
	</div>

	<p>
		<a href="<?php echo e(action('AdminKuisonerController@getIndex')); ?>" class="btn btn-primary">Kembali</a>
	</p>
	

<?php $__env->stopSection(); ?>
<?php echo $__env->make('crudbooster::admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>