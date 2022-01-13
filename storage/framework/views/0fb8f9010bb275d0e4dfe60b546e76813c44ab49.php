<?php $__env->startSection('content'); ?>


<div id="filter-relawan" class="box box-primary">
	<div class="box-header">
		<h3 class="box-title">Filter Data</h3>
		<div class="box-tools pull-right">
	        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	        </button>
	    </div>
	</div>
	<form method="get">
	<div class="box-body">
		<table class="table">
			<tr>
				<td width="30%"><strong>Nama Relawan</strong></td><td width="10px">:</td><td><input type="text" class="form-control" name="nama_relawan" value="<?php echo e(g('nama_relawan')); ?>"></td>
			</tr>
			<tr>
				<td><strong>Mulai Tanggal</strong></td><td>:</td><td><input type="text" placeholder="Semua Tanggal" class="form-control datepicker" name="mulai_tanggal" value="<?php echo e(g('mulai_tanggal')); ?>"></td>
			</tr>
			<tr>
				<td><strong>Sampai Tanggal</strong></td><td>:</td><td><input type="text" placeholder="Semua Tanggal" class="form-control datepicker" name="sampai_tanggal" value="<?php echo e(g('sampai_tanggal')); ?>"></td>
			</tr>
		</table>
	</div>
	<div class="box-footer">
		<input type="submit" class="btn btn-primary" value="Filter"> 		
	</div>
	</form>
</div>

<div class="box box-primary">
	<div class="box-header">Tabel Performa</div>
	<div class="box-body">
		<table class="table table-bordered">
			<thead>
				<tr class="active">
					<th>Nama Relawan</th>
					<th>No. HP</th>
					<th>Total Registrasi</th>
					<th>Total Pendataan</th>
					<th>Total Sosialisasi</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$queryMulaiTanggal = $querySampaiTanggal = '';

					$data = DB::table('surveyor');
					$data->addselect('*');
					
					if(g('nama_relawan')) {
						$data->where('surveyor.nama','like','%'.g('nama_relawan').'%');
					}
					if(g('mulai_tanggal')) {
						$queryMulaiTanggal = "and DATE(created_at) >= '".g('mulai_tanggal')."'";
					}
					if(g('sampai_tanggal')) {
						$querySampaiTanggal = "and DATE(created_at) <= '".g('sampai_tanggal')."'";	
					}

					$data->addselect(DB::raw("(select count(member.id) from member where id_surveyor = surveyor.id $queryMulaiTanggal $querySampaiTanggal) as total_registrasi"));
					$data->addselect(DB::raw("(select count(kuisoner.id) from kuisoner where id_surveyor = surveyor.id $queryMulaiTanggal $querySampaiTanggal) as total_pendataan"));
					$data->addselect(DB::raw("(select count(distribusi.id) from distribusi where id_surveyor = surveyor.id $queryMulaiTanggal $querySampaiTanggal) as total_sosialisasi"));
					$data = $data->paginate(20);
					foreach($data as $d):
				?>
				<tr>
					<td><?php echo e($d->nama); ?></td>
					<td><?php echo e($d->no_hp); ?></td>
					<td><?php echo e($d->total_registrasi); ?></td>
					<td><?php echo e($d->total_pendataan); ?></td>
					<td><?php echo e($d->total_sosialisasi); ?></td>
				</tr>

				<?php endforeach;?>
			</tbody>
		</table>
		<p>
			<?php echo $data->appends($_GET)->links(); ?>

		</p>
	</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('crudbooster::admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>