<div class="row">
	<div class="col-md-12">
    	<ol class="breadcrumb">                    
            <li><a href="<?=site_url('Welcome/index')?>">Dashboard</a></li>
            <li><a href="<?=site_url('User/index')?>"><?=translate('vehicles')?></a></li>
            <li class="active"><?=translate('add')?></li>
    	</ol>
   	</div>
</div>

<!--<div class="col-md-2"></div>-->
<div class="col-md-12">
    <div class="block">
        <div class="header">
            <h2><?=translate('new_vehicle_data')?></h2>
        </div>
		     
		<div class="content controls">
			<div class="block">
				<?php echo get_message_from_operation(); ?>
			</div>   
		</div>
		
        <div class="content controls">
        	<form action="<?=site_url('Vehicle/add_execute')?>" method="post" enctype="multipart/form-data">
        		<div class="form-row">
	            	<div class="col-md-3"><?=translate('car_information')?>:</div>
	                <div class="col-md-9" id="the-basics">
	                 	<input id="search" class="typeahead" value="<?=get_from_post('vehicle_model')?>" name="vehicle_model" type="text" autocomplete="off"  placeholder="<?=translate('write_to_find')?>">
	                 </div>
	            </div>
	            	            
        		<div class="form-row">
	                <div class="col-md-3"><?=translate('chassis_number')?>:</div>
	                <div class="col-md-9">
	                <input type="text" class="form-control" value="<?=get_from_post('chassis_number')?>" name="chassis_number" required="required"></div>
	            </div>
	            
	            <div class="form-row">
	                <div class="col-md-3"><?=translate('engine_number')?>:</div>
	                <div class="col-md-9">
	                <input type="text" class="form-control" value="<?=get_from_post('engine_number')?>" name="engine_number" required="required"></div>
	            </div>
				
				<div class="form-row">
	                <div class="col-md-3"><?=translate('plate_number')?>:</div>
	                <div class="col-md-9">
	                <input type="text" class="form-control" value="<?=get_from_post('plate_number')?>" name="plate_number" required="required"></div>
	            </div>				 

	            <div class="form-row">
	                <div class="col-md-3"><?=translate('total_km')?>:</div>
	                <div class="col-md-9">
	                <input type="number" class="form-control" value="<?=get_from_post('total_km')?>" name="total_km" required="required"></div>
	            </div>				 
	            
	            <div class="form-row">
	                <div class="col-md-3"><?=translate('total_color')?>:</div>
	                <div class="col-md-9">
	                <input type="color" class="form-control" value="<?=get_from_post('color')?>" name="color" required="required"></div>
	            </div>				 
	            
		       	<div class="footer">
                	<div class="side pull-right">
                  		<div class="btn-group">
                            <button class="btn btn-danger" type="button" onclick="window.history.back()"><?=translate('cancel')?></button>
                        	<button class="btn btn-success" type="submit"><?=translate('accept')?></button>
                    	</div>
                	</div>
            	</div>
			</form>
        </div>
    </div>                           
</div>

<script src="<?=base_url('template/js/bootstrap-typeahead.js')?>"> </script>
<script type="text/javascript">
 	$(function(){
		$.post("<?=site_url('Vehicle/get_models')?>", {}, function(result){
				var data  = [];
				var items = JSON.parse(result);
				for(var i = 0; i < items.length; ++i ){
					data.push( items[i] );
				}
				$('#search').typeahead({source: data});
			});
	});
</script>

