<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">                    
            <li><a href='<?= site_url("Promotion/promotion") ?>'><?= translate('promotion') ?></a></li>                    
            <li class="active"><?= translate('new_promotion') ?></li>
        </ol>
    </div>
</div>

<!--<div class="col-md-2"></div>-->
<div class="col-md-12">
    <div class="block">
        <div class="header">
            <h2><?= translate('new_promotion_data') ?></h2>
        </div>

        <div class="content controls">
            <div class="block">
                <?php echo get_message_from_operation(); ?>
            </div>   
        </div>

        <div class="content controls">
            <form action="<?= site_url('Promotion/new_promotion_execute') ?>" method="post" enctype="multipart/form-data">
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('begin') ?>:</div>
                    <div class="col-md-9">                      
                        <input name="begin" type="date" class="form-control datepicker" required="">
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('end') ?>:</div>
                    <div class="col-md-9">                      
                        <input name="end" type="date" class="form-control datepicker" required="">
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('image') ?>:</div>
                    <div class="col-md-9">                      
                        <input name="picture_id" type="file" class="form-control">
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('description') ?>:</div>
                    <div class="col-md-9">                      
                        <textarea name="description" cols="10" class="form-control" required="" ></textarea>
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