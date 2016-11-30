<div class="row">
	<div class="col-md-12">
    	<ol class="breadcrumb">                    
            <li><a href="<?=site_url('Welcome/index')?>">Dashboard</a></li>
            <li><a href="<?=site_url('User/index')?>"><?=translate('users')?></a></li>
            <li class="active"><?=translate('add')?></li>
    	</ol>
   	</div>
</div>

<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="block">
        <div class="header">
            <h2><?=translate('new_user_data')?></h2>
        </div>
		     
		<div class="content controls">
			<div class="block">
				<?php echo get_message_from_operation(); ?>
			</div>   
		</div>
		
        <div class="content controls">
        	<form action="<?=site_url('User/add_execute')?>" method="post" enctype="multipart/form-data">
        		<div class="form-row">
	                <div class="col-md-3"><?=translate('role')?></div>
	                <div class="col-md-9">
	                    <select class="form-control" name="user_role">
	                    	<option value="-1">--<?=translate('select_role')?>--</option>
	                        <?php foreach($roles as $role): ?>
	                        	<option value="<?=$role->role_id?>"><?=translate($role->role_name)?></option>
	                     	<?php endforeach; ?>
	                    </select>
	                </div>
	            </div> 
	            
        		<div class="form-row">
	                <div class="col-md-3"><?=translate('full_name')?>:</div>
	                <div class="col-md-9">
	                <input type="text" class="form-control" value="<?=get_from_post('name')?>" name="name" required="required"></div>
	            </div>
	            
	            <div class="form-row">
	                <div class="col-md-3"><?=translate('ci')?>:</div>
	                <div class="col-md-9">
	                <input type="text" class="form-control" value="<?=get_from_post('ci')?>" name="ci" required="required"></div>
	            </div>
	            
	            
	            <div class="form-row">
	                <div class="col-md-3"><?=translate('address')?>:</div>
	                <div class="col-md-9">
	                <input type="text" class="form-control" value="<?=get_from_post('address')?>" name="address" required="required"></div>
	            </div>
	            

	            <div class="form-row">
	                <div class="col-md-3"><?=translate('email')?>:</div>
	                <div class="col-md-9">
	                <input type="email" class="form-control" value="<?=get_from_post('email')?>"name="email" required="required"></div>
	            </div>
	            
	            <div class="form-row">
	                <div class="col-md-3"><?=translate('phone')?>:</div>
	                <div class="col-md-9">
	                <input type="phone" class="form-control" value="<?=get_from_post('phone')?>" name="phone" required="required"></div>
	            </div>
	            
	            <div class="form-row">
	                <div class="col-md-3"><?=translate('telephone_co')?></div>
	                <div class="col-md-9">
	                    <select class="form-control" name="cell_phone_company">
	                    	<option value="-1">--<?=translate('select_telephone_co')?>--</option>
	                        <?php foreach($cell_companies as $company): ?>
	                        	<option value="<?=$company->cell_phone_company_id?>"><?=$company->company_name?></option>
	                     	<?php endforeach; ?>
	                    </select>
	                </div>
	            </div> 
	             
	            <div class="form-row">
	                <div class="col-md-3"><?=translate('cell_phone')?>:</div>
	                <div class="col-md-9">
	                <input type="phone" class="form-control" value="<?=get_from_post('cell_phone')?>" name="cell_phone" required="required"></div>
	            </div>
	            
	             <div class="form-row">
	                <div class="col-md-3"><?=translate('password')?>:</div>
	                <div class="col-md-9">
	                <input type="password" class="form-control" value="<?=get_from_post('password')?>" name="password" required="required"></div>
	            </div>
	            
	             <div class="form-row">
	                <div class="col-md-3"><?=translate('repeat_password')?>:</div>
	                <div class="col-md-9">
	                <input type="password" class="form-control" value="<?=get_from_post('repeat_password')?>" name="repeat_password" required="required"></div>
	            </div>
	            
	            <div class="form-row">   
	            	<div class="col-md-3"><?=translate('picture')?>:</div>
	                <div class="col-md-9">
			            <div class="input-group file">                                    
			            	<input type="text" class="form-control">
			                <input type="file" name="picture" required="required">
			                <span class="input-group-btn">
			                	<button class="btn btn-primary" type="button"><?=translate("search")?></button>
			            	</span>
			            </div>  
		            </div>                  
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