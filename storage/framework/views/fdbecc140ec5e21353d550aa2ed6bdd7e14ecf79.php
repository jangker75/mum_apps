<!DOCTYPE html>
<html>
<head>
	<title>Detail Survey / Kuisoner</title>
	<style type="text/css">
		.outer {
			font-family: Tahoma;
			margin: 0 auto;
			width: 780px;
			border: 1px solid #eee;
			padding: 20px;
		}
		table tr td {
			vertical-align: top;
		}
		.label {
			font-weight: bold;
			color: red;
		}
		.value {
			padding:5px 0px 5px 0px;
			border-bottom: 1px solid #cccccc;
		}
		@media  print {
			.no-print {
				display: none !important;
			}
		}
		.green {
			color: green;
		}
	</style>
</head>
<body>
	<div class="outer">
		<div class="no-print" style="text-align: center">
			<button type="button" onclick="window.print()">PRINT</button> 
			<button type="button" onclick="location.href='<?php echo e(action("AdminKuisonerController@getIndex")); ?>'">KEMBALI</button>
		</div>
		<table width="100%">
			<tbody>
				<tr>
					<td width="40$">
						<div class="label">Nomor Kuisoner</div>
						<div class="value"><?php echo e($row->no_kuisoner?:"&nbsp;"); ?></div>
					</td>
					<td width="20$">
						&nbsp;
					</td>
					<td width="40$">
						<div class="label">RW</div>
						<div class="value"><?php echo e($row->rw?:"&nbsp;"); ?></div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="label">Nama Responden</div>
						<div class="value"><?php echo e($row->nama_responden?:"&nbsp;"); ?></div>
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						<div class="label">Desa/Kelurahan</div>
						<div class="value"><?php echo e($row->desa_kelurahan?:"&nbsp;"); ?></div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="label">Nomor HP Responden</div>
						<div class="value"><?php echo e($row->no_hp_responden?:"&nbsp;"); ?></div>
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						<div class="label">Kecamatan</div>
						<div class="value"><?php echo e($row->kecamatan?:"&nbsp;"); ?></div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="label">Nama KK</div>
						<div class="value"><?php echo e($row->nama_kk?:"&nbsp;"); ?></div>
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						<div class="label">Kabupaten/Kota</div>
						<div class="value"><?php echo e($row->kabupaten_kota?:"&nbsp;"); ?></div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="label">RT</div>
						<div class="value"><?php echo e($row->rt?:"&nbsp;"); ?></div>
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						<div class="label">Tanda Tangan Responden</div>
						<div class="value"><?php echo $row->ttd_responden?"<a target=\"_blank\" href='".asset($row->ttd_responden)."'>Lihat TTD</a>":"&nbsp;"; ?></div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="label">Nama Relawan</div>
						<div class="value"><?php echo e($row->surveyor_nama?:"&nbsp;"); ?></div>
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						<div class="label">No HP Relawan</div>
						<div class="value"><?php echo e($row->surveyor_no_hp?:"&nbsp;"); ?></div>
					</td>
				</tr>
			</tbody>
		</table>

		<h2>Pertanyaan</h2>
		<ol>
		<?php 
			$soal = DB::table('soal')
			->whereNull('deleted_at')
			->where('id_event',$row->id_event)
			->orderby('urutan','asc')
			->get();
			foreach($soal as $s): 				
		?>
			<li><?php echo e($s->isi); ?>

				<?php if($s->tipe == 'Text'): ?>
					<?php 
						$cekText = DB::table('kuisoner_detail')->where('id_kuisoner',$row->id)->where('id_soal',$s->id)->first();
					?>
					<p><em><?php echo e($cekText->keterangan); ?></em></p>
				<?php else: ?>
				<ol>
					<?php 
						$soalJawaban = DB::table('soal_jawaban')
						->whereNull('deleted_at')
						->where('id_soal',$s->id)
						->get();
					?>
					<?php $__currentLoopData = $soalJawaban; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ss): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php 
							$cek = DB::table('kuisoner_detail')
							->where('id_kuisoner',$row->id)
							->where('id_soal',$s->id)
							->where('id_soal_jawaban',$ss->id)
							->first();
						?>
						<li class="<?php echo e(($cek)?'green':''); ?>">
							<?php echo e($ss->jawaban); ?>

							<?php if($ss->input_keterangan && $cek): ?>
								( <?php echo e($cek->keterangan); ?> )
							<?php endif; ?>

							<?php if($cek): ?> 
								&#10003;&nbsp; 
							<?php endif; ?> 
						</li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</ol>
				<?php endif; ?>
			</li>
		<?php endforeach;?>
		</ol>

		<p style="text-align: center">
			<?php if($row->photo1): ?>
				<a href="<?php echo e(asset($row->photo1)); ?>" target="_blank"><img src="<?php echo e(asset($row->photo1)); ?>" width="110px" height="110px"></a>
			<?php endif; ?>
			<?php if($row->photo2): ?>
				<a href="<?php echo e(asset($row->photo2)); ?>" target="_blank"><img src="<?php echo e(asset($row->photo2)); ?>" width="110px" height="110px"></a>
			<?php endif; ?>
			<?php if($row->photo3): ?>
				<a href="<?php echo e(asset($row->photo3)); ?>" target="_blank"><img src="<?php echo e(asset($row->photo3)); ?>" width="110px" height="110px"></a>
			<?php endif; ?>
		</p>
	</div>
</body>
</html>