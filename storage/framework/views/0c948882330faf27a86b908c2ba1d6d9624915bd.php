<?php echo $__env->make("crudbooster::emails.header", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $content; ?>


<?php echo $__env->make("crudbooster::emails.footer", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
