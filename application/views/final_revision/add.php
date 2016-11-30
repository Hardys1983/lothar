<?php 
	$total_km 	= 0;
	$fuel_level = -1;
	$abc        = FALSE;
	
	if( isset($revision)){
		$fuel_level = $revision->fuel_level;
		$total_km 	= $revision->total_km;
		
		if($revision->abc){
			$abc = TRUE;
		}
	}
?>

<script type='text/javascript' src='<?=base_url('template/js/plugins/uniform/jquery.uniform.min.js')?>'></script>

<div class="row">
	<div class="col-md-12">
    	<ol class="breadcrumb">                    
            <li><a href="<?=site_url('Welcome/index')?>">Dashboard</a></li>
            <li><a href="<?=site_url('Vehicular_reception/index')?>"><?=translate('vehicular_orders')?></a></li>
            <li><a href="<?=site_url("Vehicular_reception/show_work_order/$work_order->work_order_id")?>"><?=translate('work_order')?></a></li>
            <li class="active"><?=translate('final_revision')?></li>
    	</ol>
   	</div>
</div>

<!--<div class="col-md-2"></div>-->
<div class="col-md-12">
    <div class="block">
        <div class="header">
            <h2><?=translate('final_revision')." ".date("Y-m-d")?></h2>
        </div>
		     
		<div class="content controls">
			<div class="block">
				<?php echo get_message_from_operation(); ?>
			</div>   
		</div>
		
        <div class="content controls">
        	<form id="frmNewOrder" action="<?=site_url('Final_revision/add_execute')?>" method="post">
                <div class="form-row">
	                <div class="col-md-3"><?=translate('km_traveled')?>:</div>
	                <div class="col-md-9">
	             	<input id="spinner" type="text" class="form-control" name="km" value="<?=$total_km?>">
	             	</div>
	            </div>
	            
	            <div class="form-row">
	                <div class="col-md-3"><?=translate('fuel_level')?>:</div>
	                <div class="col-md-9">
	                	<select class="form-control" name="fuel_level" id="fuel_level">
	                    	<option <?php if($fuel_level ==  '-1') echo "selected"; ?> value="-1">--<?=translate('fuel_level')?>--</option>
	                        <option <?php if($fuel_level ==   '0') echo "selected"; ?> value="0"><?=translate('empty')?></option>          		                        	
	                        <option <?php if($fuel_level ==  '25') echo "selected"; ?> value="25">25%</option>
	                        <option <?php if($fuel_level ==  '50') echo "selected"; ?> value="50">50%</option>
	                        <option <?php if($fuel_level ==  '75') echo "selected"; ?> value="75">75%</option>
	                        <option <?php if($fuel_level == '100') echo "selected"; ?> value="100"><?=translate('full')?></option>          		                        	
	                    </select>
	                </div>
	            </div>
	            
	            <div class="form-row">
	                <div class="col-md-3"><?=translate('abc_done')?>:</div>
	                <div class="col-md-9">
						<input id="abc" type="checkbox" name="abc" value="1" >	                            	
					</div>
	            </div>
	            
	            <input type="hidden" name="work_order_id" value="<?=$work_order->work_order_id?>" >
   				<div class="footer">
                	<div class="side pull-right">
                  		<div class="btn-group">
                            <button class="btn btn-danger" type="button" onclick="closeNewOrder()"><?=translate('cancel')?></button>
                        	<button class="btn btn-success" type="submit"><?=translate('accept')?></button>
                    	</div>
                	</div>
            	</div>
			</form>
			</div>  
        </div>
    </div>                           
</div>

<script type="text/javascript">
	
	$(function(){
		function init(){
			var result = '<?=$abc?>';
			if(result){
				$('#abc').trigger('click');
			}
		}
		
		init();
	});
</script>
