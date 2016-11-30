<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">                    
            <li><a href='<?= site_url("Banner/banner") ?>'><?= translate('banner') ?></a></li>                    
            <li class="active"><?= translate('new_banner') ?></li>
        </ol>
    </div>
</div>

<div class="col-md-2"></div>
<div class="col-md-12">
    <div class="block">
        <div class="header">
            <h2><?= translate('new_banner_data') ?></h2>
        </div>

        <div class="content controls">
            <div class="block">
                <?php echo get_message_from_operation(); ?>
            </div>   
        </div>

        <div class="content controls">
            <form action="<?= site_url('Banner/new_banner_execute') ?>" method="post" enctype="multipart/form-data">
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('title') ?>:</div>
                    <div class="col-md-9">                      
                        <input name="title" type="text" class="form-control" required="">
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('image') ?>:</div>
                    <div class="col-md-9">                      
                        <input name="picture_id" type="file" class="form-control">
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('sub_title') ?>:</div>
                    <div class="col-md-9">                      
                        <input name="sub_title" class="form-control" required="" >
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('state') ?>:</div>
                    <div class="col-md-9">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="radio" value="0" name="state"  checked="checked">
                                </span>
                                <input type="text" class="form-control" aria-label="..." disabled="" value="<?= translate('state_pending') ?>">
                            </div><!-- /input-group -->
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="radio" value="3" name="state">
                                </span>
                                <input type="text" class="form-control" aria-label="..." disabled="" value="<?= translate('state_approved') ?>">
                            </div><!-- /input-group -->
                        </div>
                    </div> 
                </div>

                <div class="footer">
                    <div class="side pull-right">
                        <div class="btn-group">
                            <button class="btn btn-danger" type="button" onclick="window.history.back()"><?= translate('cancel') ?></button>
                            <button class="btn btn-success" type="submit"><?= translate('accept') ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>                           
</div>