<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">                    
            <li><a href='<?= site_url("News/news") ?>'><?= translate('news') ?></a></li>                    
            <li class="active"><?= translate('new_news') ?></li>
        </ol>
    </div>
</div>

<!--<div class="col-md-2"></div>-->
<div class="col-md-12">
    <div class="block">
        <div class="header">
            <h2><?= translate('new_news_data') ?></h2>
        </div>

        <div class="content controls">
            <div class="block">
                <?php echo get_message_from_operation(); ?>
            </div>   
        </div>

        <div class="content controls">
            <div class="block">
                <div class="col-md-12">
                    <img class="image_news_update" src="<?php echo base_url() . $news->main_image ?>">
                </div>
            </div>   
        </div>

        <div class="content controls">
            <form action="<?= site_url('News/update_news_execute') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="news_id" value="<?= $news->news_id?>">
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('title') ?>:</div>
                    <div class="col-md-9">                      
                        <input name="title" type="text" class="form-control" required="" value="<?= $news->title ?>"> 
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('date') ?>:</div>
                    <div class="col-md-9">                      
                        <input name="date" type="date" class="form-control datepicker" required="" value="<?= $news->date ?>">
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('image') ?>:</div>
                    <div class="col-md-9">                      
                        <input name="main_image" type="file" class="form-control">
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('content') ?>:</div>
                    <div class="col-md-9">                      
                        <textarea name="content" cols="10" class="form-control" required="" ><?= $news->content ?></textarea>
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('state') ?>:</div>
                    <div class="col-md-9">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="radio" value="0" name="state"  <?php
                                    if ($news->state == 0) {
                                        echo "checked";
                                    }
                                    ?>>
                                </span>
                                <input type="text" class="form-control" aria-label="..." disabled="" value="<?= translate('state_pending') ?>">
                            </div><!-- /input-group -->
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="radio" value="3" name="state" <?php
                                    if ($news->state == 3) {
                                        echo "checked";
                                    }
                                    ?>>
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