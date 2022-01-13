<?php $__env->startPush('bottom'); ?>
<script type="text/javascript">
								$(document).ready(function() {
								  $('#textarea_<?php echo e($name); ?>').summernote({
								  	height: ($(window).height() - 300),
								    callbacks: {
								        onImageUpload: function(image) {
								            uploadImage<?php echo e($name); ?>(image[0]);
								        }
								    }
								  });
								  function uploadImage<?php echo e($name); ?>(image) {
									    var data = new FormData();
									    data.append("userfile", image);
									    $.ajax({
									        url: '<?php echo e(CRUDBooster::mainpath("upload-summernote")); ?>',
									        cache: false,
									        contentType: false,
									        processData: false,
									        data: data,
									        type: "post",
									        success: function(url) {
									            var image = $('<img>').attr('src',url);
									            $('#textarea_<?php echo e($name); ?>').summernote("insertNode", image[0]);
									        },
									        error: function(data) {
									            console.log(data);
									        }
									    });
									}
								})
							</script>
							<?php $__env->stopPush(); ?>
							<div class='form-group' id='form-group-<?php echo e($name); ?>' style="<?php echo e(@$form['style']); ?>">
								<label class='control-label col-sm-2'><?php echo e($form['label']); ?></label>

								<div class="<?php echo e($col_width?:'col-sm-10'); ?>">
									<textarea id='textarea_<?php echo e($name); ?>' id="<?php echo e($name); ?>" <?php echo e($required); ?> <?php echo e($readonly); ?> <?php echo e($disabled); ?> name="<?php echo e($form['name']); ?>" class='form-control' rows='5'><?php echo e($value); ?></textarea>
									<div class="text-danger"><?php echo e($errors->first($name)); ?></div>
									<p class='help-block'><?php echo e(@$form['help']); ?></p>
								</div>
						</div>
