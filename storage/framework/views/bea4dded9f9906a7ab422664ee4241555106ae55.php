<?php $__env->startSection('content'); ?>

<?php $__env->startPush('bottom'); ?>
	<script type="text/javascript">
		var noJawaban = 1;
		
		function addJawaban(no_soal) {
			$('.wrap-jawaban .tr-empty').remove();
			var jawaban = $("#soal"+no_soal+" .master-input-jawaban").val();
			var ket = $("#soal"+no_soal+" .master-select-keterangan").val();
			var ket_text = (ket==0)?"<input type='hidden' name='input_keterangan["+no_soal+"][]' value='0'/>TIDAK":"<input type='hidden' name='input_keterangan["+no_soal+"][]' value='1'/>YA";
			var tr = "<tr>";
			tr += "<td>#</td><td><input type='hidden' name='jawaban["+no_soal+"][]' value='"+jawaban+"'/>"+jawaban+"</td><td>"+ket_text+"</td><td><a href='javascript:;' class='btn btn-warning btn-delete-jawaban btn-sm'>Delete</a></td>";
			tr += "</tr>";
			$('#soal'+no_soal+' .wrap-jawaban tbody').append(tr);
			$('#soal'+no_soal+' .master-input-jawaban').val('').focus();
			noJawaban += 1;
		}

		$(function() {
			$(document).on('click','.btn-delete-jawaban',function() {
				$(this).parent().parent().remove();
			})
		})
	</script>
<?php $__env->stopPush(); ?>

<div class="panel panel-default">
	<div class="panel-heading">Soal</div>
	<form method="post" action="">
	<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
	<div class="panel-body panel-body-soal">

		<div class="form-group">
			<label>Event</label>
			<select class="form-control" name="id_event" required >
				<option value="">** Pilih Event</option>
				<?php 
					$event = DB::table('event')
					->orderby('nama','asc')
					->whereNull('deleted_at')
					->get();
					foreach($event as $e):
				?>
					<option <?php echo e($row->id_event==$e->id?"selected":""); ?> value="<?php echo e($e->id); ?>"><?php echo e($e->nama); ?></option>
				<?php endforeach;?>
			</select>
		</div>

		<!-- <div class="form-group">
			<label>Jenis</label>			
			<input type="radio" name="jenis" <?php echo e($row->jenis=='Distribusi'?'checked':''); ?> value="Distribusi"> Distribusi 
			<input type="radio" name="jenis" <?php echo e($row->jenis=='Survey'?'checked':''); ?> value="Survey"> Survey 
		</div> -->

		<div class="form-group">
			<label>Soal</label>
			<input type="text" class="form-control" required name="isi" value="<?php echo e($row->isi); ?>">
		</div>

		<div class="form-group">
			<label>Keterangan</label>
			<input type="keterangan" class="form-control" name="keterangan" value="<?php echo e($row->keterangan); ?>">
		</div>

		<div class="form-group">
			<label>Urutan</label>
			<input type="number" style="width: 150px" class="form-control" required name="urutan" value="<?php echo e($row->urutan); ?>">
		</div>

		<div class="form-group">
			<label>Tipe</label>
			<select class="form-control" name="tipe" required >
				<option value="">** Pilih Tipe</option>
				<option <?php echo e($row->tipe=='Radio'?"selected":""); ?> value="Radio">Radio</option>
				<option <?php echo e($row->tipe=='Checkbox'?"selected":""); ?> value="Checkbox">Checkbox</option>
				<option <?php echo e($row->tipe=='Text'?"selected":""); ?> value="Text">Text</option>
				<option <?php echo e($row->tipe=='Upload Image'?"selected":""); ?> value="Upload Image">Upload Image</option>
			</select>
		</div>

		<div class="form-group">
			<label>Jumlah Upload</label>
			<input type="number" style="width: 150px" class="form-control" name="jumlah_upload" value="<?php echo e($row->jumlah_upload); ?>">
		</div>

		<table id='soal1' data-no='1' class="table table-striped table-soal">
			<tbody>
				<tr><td>Jawaban </td><td>:</td><td>
					<div class="wrap-jawaban">
						<table class="table table-striped table-bordered">
							<tbody>
								<tr class="active master-tr-input-jawaban">
									<td>#</td>
									<td width="70%"><input type="text" class="form-control master-input-jawaban"></td>
									<td><select class="form-control master-select-keterangan">
									<option value="">** Keterangan ?</option>
									<option value="0">TIDAK</option>
									<option value="1">YA</option>
									</select></td>
									<td><a class="btn btn-primary btn-sm" href="javascript:;" onclick='addJawaban(1)'>Tambah</a></td>
								</tr>
								<?php 
									$soaljawaban = DB::table('soal_jawaban')
									->whereNull('deleted_at')
									->where('id_soal',$row->id)
									->get();
									foreach($soaljawaban as $s):
								?>
									<tr>
										<td>#</td>
										<td><?php echo e($s->jawaban); ?></td>
										<td>
											<?php echo e($s->input_keterangan?"YA":"TIDAK"); ?>

										</td>
										<td>
											<a href='<?php echo e(action("AdminSoalController@getDeleteJawaban",["id"=>$s->id])); ?>' class='btn btn-warning btn-sm'>Delete</a> 
										</td>
									</tr>
								<?php endforeach;?>
								<?php if(count($soaljawaban)==0): ?>
								<tr class="tr-empty">
									<td colspan="3" align="center">There is no data</td>
								</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</td></tr>
			</tbody>
		</table>


	</div>
	<div class="panel-footer">
		<input type="submit" class="btn btn-success" value="Simpan Soal"> 
		<a href="<?php echo e(url('admin/'.CRUDBooster::getCurrentModule()->path)); ?>" class="btn btn-default">Kembali</a> 
	</div>
	</form>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('crudbooster::admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>