<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">                    
            <li><a href='<?= site_url("Mechanic/activities/$activity->work_order_id") ?>'><?= translate('activities') ?></a></li>                    
            <li class="active"><?= translate('update') ?></li>
        </ol>
    </div>
</div>

<!--<div class="col-md-2"></div>-->
<div class="col-md-12">
    <div class="block">
        <div class="header">
            <h2><?= translate('new_activity_data') ?></h2>
        </div>

        <div class="content controls">
            <div class="block">
                <?php echo get_message_from_operation(); ?>
            </div>   
        </div>

        <div class="content controls">
            <form action="<?= site_url('Mechanic/update_activity_execute') ?>" method="post">
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('activity_type') ?>:</div>
                    <div class="col-md-9">
                        <input type="text" disabled="" value="<?= $operation_type ?>">
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('description') ?>:</div>
                    <div class="col-md-9">                      
                        <input name="description" value='<?= $activity->description ?>' type="text" class="form-control">
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('time_estimated_hr') ?>:</div>
                    <div class="col-md-9">                      
                        <input name="time_estimated" value="<?= $activity->time_estimated_hours ?>" type="text" class="form-control" disabled="">
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('time_used_hr') ?>:</div>
                    <div class="col-md-9">                      
                        <input name="time_used" value="<?= $activity->time_used ?>" type="number" class="form-control">
                    </div>                  
                </div>
                <?php if ($activity->state == 0) { ?>
                    <div class="form-row">   
                        <div class="col-md-3"><?= translate('state') ?>:</div>
                        <div class="col-md-9">
                            <div class="input-group">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <input type="radio" value="0" name="state"  <?php
                                            if ($activity->state == 0) {
                                                echo "checked";
                                            }
                                            ?>>
                                        </span>
                                        <input type="text" class="form-control" aria-label="..." disabled="" value="<?= translate('state_pending') ?>">
                                    </div><!-- /input-group -->
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <input type="radio" value="1" name="state" <?php
                                            if ($activity->state == 1) {
                                                echo "checked";
                                            }
                                            ?>>
                                        </span>
                                        <input type="text" class="form-control" aria-label="..." disabled="" value="<?= translate('state_finish') ?>">
                                    </div><!-- /input-group -->
                                </div>
                            </div>                  
                        </div>
                    </div>
                <?php } else { ?>
                    <input type="hidden" name="state" value="<?= $activity->state ?>">
                <?php } ?>
                <div class="footer">
                    <div class="side pull-right">
                        <div class="btn-group">
                            <button class="btn btn-danger" type="button" onclick="window.history.back()"><?= translate('cancel') ?></button>
                            <button class="btn btn-success" type="submit"><?= translate('accept') ?></button>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="activity_id" value=<?= $activity->operation_id ?> >
            </form>
        </div>
    </div>                           
</div>