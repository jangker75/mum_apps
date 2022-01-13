
                		<div class='form-group peta <?php echo e($header_group_class); ?> <?php echo e(($errors->first($name))?"has-error":""); ?>'>
                			<label class='control-label col-sm-2'><?php echo e($form['label']); ?> <?php echo ($required)?"<span class='text-danger' title='This field is required'>*</span>":""; ?></label>
                			
                			<div class="<?php echo e($col_width?:'col-sm-10'); ?>">


                			<div class="input-group">
						      <input type="text" class="form-control" id="<?php echo e($name); ?>" <?php echo e(($readonly)?"readonly":""); ?> <?php echo e(($required)?"required":""); ?> value="<?php echo e($value); ?>" name="<?php echo e($name); ?>">
						      <input type="hidden" name="input-latitude-<?php echo e($name); ?>" id="input-latitude-<?php echo e($name); ?>" value="<?php echo e(($form['latitude'])?$row->$form['latitude']:0); ?>">
						      <input type="hidden" name="input-longitude-<?php echo e($name); ?>" id="input-longitude-<?php echo e($name); ?>" value="<?php echo e(($form['longitude'])?$row->$form['longitude']:0); ?>">
						      <span class="input-group-btn">
						        <button class="btn btn-primary" onclick="showMapModal<?php echo e($name); ?>()" type="button"><i class='fa fa-map-marker'></i> Browse Map</button>
						      </span>
						    </div><!-- /input-group -->


						    <div id='googlemaps-modal-<?php echo e($name); ?>' class="modal fade" tabindex="-1" role="dialog">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        <h4 class="modal-title"><i class='fa fa-search'></i> Browse Map</h4>
							      </div>
							      <div class="modal-body">
							        
							      	<input id="input-search-autocomplete-<?php echo e($name); ?>" class="controls pac-input" autofocus type="text"
								        placeholder="Search location here...">
								    <div id="type-selector-<?php echo e($name); ?>" class="controls hide type-selector">
								      <input type="radio" name="type" id="changetype-all" checked="checked">
								      <label for="changetype-all">All</label>

								      <input type="radio" name="type" id="changetype-establishment">
								      <label for="changetype-establishment">Establishments</label>

								      <input type="radio" name="type" id="changetype-address">
								      <label for="changetype-address">Addresses</label>

								      <input type="radio" name="type" id="changetype-geocode">
								      <label for="changetype-geocode">Geocodes</label>
								    </div>
								    <div class="map" id='map-<?php echo e($name); ?>'></div>
								    <br/>
								    <p>
								    	<span class="text-info" style="font-weight: bold">Current Location :</span><br/>
								    	<span id='current-location-span-<?php echo e($name); ?>'><?php echo e(($value)?$value:'-'); ?></span>
								    </p>

							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-primary" onclick="setIt<?php echo e($name); ?>()" data-dismiss="modal">Set It</button>							        
							      </div>
							    </div><!-- /.modal-content -->
							  </div><!-- /.modal-dialog -->
							</div><!-- /.modal -->


							

						    </div>
						</div>
						<?php $__env->startPush('bottom'); ?>
                		<script type="text/javascript">
                		  

                		  	var address_temp_<?php echo e($name); ?>,latitude_temp_<?php echo e($name); ?>,longitude_temp_<?php echo e($name); ?>;

                		  	function setIt<?php echo e($name); ?>() {
                		  		console.log(address_temp_<?php echo e($name); ?>);
                		  		$('#<?php echo e($name); ?>').val(address_temp_<?php echo e($name); ?>);
                		  		$("#input-latitude-<?php echo e($name); ?>").val(latitude_temp_<?php echo e($name); ?>);
						        $("#input-longitude-<?php echo e($name); ?>").val(longitude_temp_<?php echo e($name); ?>);	
                		    }

                			var is_init_map_<?php echo e($name); ?> = false;
                		  function showMapModal<?php echo e($name); ?>() {
                		  	var api_key = "<?php echo e(CRUDBooster::getSetting('google_api_key')); ?>";

                		  	if(api_key == '') {
                		  		alert('GOOGLE_API_KEY is missing, please set at setting !');                		  		
                		  		return false;
                		  	}

                		  	$('#googlemaps-modal-<?php echo e($name); ?>').modal('show');                		  	                		  
                		  }

                		  $('#googlemaps-modal-<?php echo e($name); ?>').on('shown.bs.modal', function(){
                		  		if(is_init_map_<?php echo e($name); ?> == false) {
	                		  		console.log('Init Map <?php echo e($name); ?>');
	                		  		initMap<?php echo e($index); ?>();
	                		  		is_init_map_<?php echo e($name); ?> = true;
	                		  	}
                		  });

                		  var geocoder;
                		  
					      function initMap<?php echo e($index); ?>() {
					      	geocoder = new google.maps.Geocoder();
					        var map = new google.maps.Map(document.getElementById('map-<?php echo e($name); ?>'), {
					          <?php if($row->{$form['latitude']} && $row->{$form['longitude']}): ?>
							  	center: {lat: <?php echo $row->{$form['latitude']}?:0;?>, lng: <?php echo $row->{$form['longitude']}?:0;?> },
							  <?php endif; ?>
					          zoom: 12
					        });	

					        var marker_default_location = new google.maps.Marker({
					          map: map,
					          draggable:true,					          					          
					        });				        							
					       
					        var input = /** @type    {!HTMLInputElement} */(
					            document.getElementById('input-search-autocomplete-<?php echo e($name); ?>'));

					        var types = document.getElementById('type-selector-<?php echo e($name); ?>');
					        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
					        map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

					        var autocomplete = new google.maps.places.Autocomplete(input);
					        autocomplete.bindTo('bounds', map);

					        var infoWindow = new google.maps.InfoWindow();

					        // Try HTML5 geolocation.

					        <?php if(!$row->$form['latitude'] && !$row->$form['longitude']): ?>

					        	latitude_temp_<?php echo e($name); ?> = 0;
					          	longitude_temp_<?php echo e($name); ?> = 0;
					            var pos = {
					              lat: latitude_temp_<?php echo e($name); ?>,
					              lng: longitude_temp_<?php echo e($name); ?>

					            };
					            map.setCenter(pos);					            					            					      
					            map.setZoom(1);

					        <?php else: ?> 
					        	var pos = {
					              lat: <?php echo e($row->$form['latitude']?:0); ?>,
					              lng: <?php echo e($row->$form['longitude']?:0); ?>

					            };

					            latitude_temp_<?php echo e($name); ?> = <?php echo e($row->$form['latitude']?:0); ?>;
					          	longitude_temp_<?php echo e($name); ?> = <?php echo e($row->$form['longitude']?:0); ?>;

					          	address_temp_<?php echo e($name); ?> = "<?php echo e($value); ?>";

					            map.setCenter(pos);
								    
							   	marker_default_location.setPosition(pos);

							   	infoWindow.close();
							  	infoWindow.setContent("<?php echo e($value); ?>");
				          		infoWindow.open(map, marker_default_location);

					        <?php endif; ?>

					        google.maps.event.addListener(marker_default_location, 'dragend', function(marker_default_location){
					        	
					        	  geocoder.geocode({
								    latLng: marker_default_location.latLng
								  }, function(responses) {
								    if (responses && responses.length > 0) {
								      address = responses[0].formatted_address;
								    } else {
								      address = 'Cannot determine address at this location.';
								    }

								    address_temp_<?php echo e($name); ?> = address;

								    infoWindow.setContent(address);								    
								   								  	
								  	$('#current-location-span-<?php echo e($name); ?>').text(address);															    
								    
								  });

						        var latLng = marker_default_location.latLng; 
						        latitude = latLng.lat();
						        longitude = latLng.lng();
						        						          
						        latitude_temp_<?php echo e($name); ?> = latitude;
						        longitude_temp_<?php echo e($name); ?> = longitude;

						     });

					        autocomplete.addListener('place_changed', function() {
					          infoWindow.close();
					          marker_default_location.setVisible(false);

					          var place = autocomplete.getPlace();

					          if (!place.geometry) {
					            window.alert("Autocomplete's returned place contains no geometry");
					            return;
					          }
					      
					          if (place.geometry.viewport) {
					            map.fitBounds(place.geometry.viewport);
					          } else {
					            map.setCenter(place.geometry.location);
					            map.setZoom(17); 
					          }
			
					          marker_default_location.setPosition(place.geometry.location);
					          marker_default_location.setVisible(true);

					          var address = '';
					          if (place.address_components) {
					            address = [
					              (place.address_components[0] && place.address_components[0].short_name || ''),
					              (place.address_components[1] && place.address_components[1].short_name || ''),
					              (place.address_components[2] && place.address_components[2].short_name || '')
					            ].join(' ');
					          }

					          var latitude = place.geometry.location.lat();
							  var longitude = place.geometry.location.lng(); 

							  address_temp_<?php echo e($name); ?> = address;

							  $('#current-location-span-<?php echo e($name); ?>').text(address);

							  infoWindow.setContent(address);

							  latitude_temp_<?php echo e($name); ?> = latitude;
							  longitude_temp_<?php echo e($name); ?> = longitude;							  

					          infoWindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
					          infoWindow.open(map, marker_default_location);
					        });

					        function setupClickListener(id, types) {
					          var radioButton = document.getElementById(id);
					          radioButton.addEventListener('click', function() {
					            autocomplete.setTypes(types);
					          });
					        }

					        setupClickListener('changetype-all', []);
					        setupClickListener('changetype-address', ['address']);
					        setupClickListener('changetype-establishment', ['establishment']);
					        setupClickListener('changetype-geocode', ['geocode']);
					      }
					      
					    </script>		
					    <?php $__env->stopPush(); ?>        					    