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

		function addSoal() {
			var lastNo = $('.table-soal:last-child').data('no');
			lastNo = parseInt(lastNo) + 1;
			var html = "<table id='soal"+lastNo+"' data-no='"+lastNo+"' class='table table-striped table-soal'>";
				html += "<tbody>";
				html += '<tr><td>Soal #'+lastNo+'</td><td>:</td><td><input type="text" class="form-control" name="isi['+lastNo+']" required ></td></tr>';
				html += '<tr><td>Urutan #'+lastNo+'</td><td>:</td><td><input type="number" class="form-control" name="urutan['+lastNo+']" required ></td></tr>';
				html += '<tr><td>Tipe #'+lastNo+'</td><td>:</td><td><select class=\'form-control\' name=\'tipe['+lastNo+']\' required ><option value="Radio">Radio</option><option value="Checkbox">Checkbox</option><option value="Text">Text</option></select></td></tr>';
				html += '<tr><td>Jawaban #'+lastNo+'</td><td>:</td><td>';
				html += '<div class="wrap-jawaban">';
				html += '<table class="table table-striped table-bordered">';
				html += '<tbody>';
				html += '<tr class="active master-tr-input-jawaban">';
				html += '<td>#</td>';
				html += '<td width="70%"><input type="text" class="form-control master-input-jawaban"></td>';
				html += '<td><select class="form-control master-select-keterangan">';
				html += '<option value="">** Keterangan ?</option>';
				html += '<option value="0">TIDAK</option>';
				html += '<option value="1">YA</option>';
				html += '</select></td>';
				html += '<td><a class="btn btn-primary btn-sm" href="javascript:;" onclick=\'addJawaban('+lastNo+')\'>Tambah</a></td>';
				html += '</tr>';
				html += '<tr class="tr-empty">';
				html += '<td colspan="3" align="center">There is no data</td>';
				html += '</tr>';
				html += '</tbody>';
				html += '</table>';
				html += '</div>';
				html += '</td></tr>';
				html += '</tbody>';
				html += '</table>';
			$('.panel-body-soal').append(html);
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
					$event = DB::table('event')->orderby('nama','asc')->get();
					foreach($event as $e):
				?>
					<option value="<?php echo e($e->id); ?>"><?php echo e($e->nama); ?></option>
				<?php endforeach;?>
			</select>
		</div>

		<table id='soal1' data-no='1' class="table table-striped table-soal">
			<tbody>
				<tr><td>Soal #1</td><td>:</td><td><input type="text" class="form-control" name="isi[1]" required ></td></tr>
				<tr><td>Urutan #1</td><td>:</td><td><input type="text" class="form-control" name="urutan[1]" required ></td></tr>
				<tr><td>Tipe #1</td><td>:</td><td><select class='form-control' name='tipe[1]' required ><option value="Radio">Radio</option><option value="Checkbox">Checkbox</option><option value="Text">Text</option></select></td></tr>
				<tr><td>Jawaban #1</td><td>:</td><td>
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
								<tr class="tr-empty">
									<td colspan="3" align="center">There is no data</td>
								</tr>
							</tbody>
						</table>
					</div>
				</td></tr>
			</tbody>
		</table>


	</div>
	<div class="panel-footer">
		<input type="submit" class="btn btn-success" value="Simpan Soal"> 
		<a href="<?php echo e(action('AdminSoalController@getIndex')); ?>" class="btn btn-default">Kembali</a> 
		<a href="javascript:;" onclick="addSoal()" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Tambah Soal</a>
	</div>
	</form>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('crudbooster::admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>