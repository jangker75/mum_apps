
<?php if($form['latitude'] && $form['longitude']): ?>
	<a href='javascript:void(0)' onclick='showModalMap<?php echo e($name); ?>()' title="Click to view the map">
	<i class='fa fa-map-marker'></i> <?php echo e($value); ?>

	</a>
<?php else: ?>
	<?php echo e($value); ?>

<?php endif; ?>


<div id='googlemaps-modal-<?php echo e($name); ?>' class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class='fa fa-search'></i> View Map</h4>
      </div>
      <div class="modal-body">
        
	    <div class="map" id='map-<?php echo e($name); ?>'></div>

      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php $__env->startPush('bottom'); ?>							
<script type="text/javascript">
function showModalMap<?php echo e($name); ?>() {
	$('#googlemaps-modal-<?php echo e($name); ?>').modal('show');
}
var is_init_map_<?php echo e($name); ?> = false;
$('#googlemaps-modal-<?php echo e($name); ?>').on('shown.bs.modal', function(){
	if(is_init_map_<?php echo e($name); ?> == false) {  		
  		initMap<?php echo e($name); ?>();
  		is_init_map_<?php echo e($name); ?> = true;
  	}
});
function initMap<?php echo e($name); ?>() {	
	<?php if($row->{$form['latitude']} && $row->{$form['longitude']}): ?>
		var map = new google.maps.Map(document.getElementById('map-<?php echo e($name); ?>'), {	  
		  	center: {lat: <?php echo $row->{$form['latitude']}?:0;?>, lng: <?php echo $row->{$form['longitude']}?:0;?> },
		  	zoom: 12
		});
		var infoWindow = new google.maps.InfoWindow();

		var marker = new google.maps.Marker({
		  position: {lat: <?php echo $row->{$form['latitude']}?:0;?>, lng: <?php echo $row->{$form['longitude']}?:0;?> },
		  map: map,					          
		  title: '<?php echo e($value); ?>'
		});		

		infoWindow.close();
	  	infoWindow.setContent("<?php echo e($value); ?>");
  		infoWindow.open(map, marker);
	<?php else: ?>										    				
		$('#googlemaps-modal-<?php echo e($name); ?> .modal-body').html("<div align='center'>Sorry the map is not found !</div>");
	<?php endif; ?>						    
} 
</script>		
<?php $__env->stopPush(); ?>        					    
