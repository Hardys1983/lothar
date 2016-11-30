<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">                    
            <li><a href='<?= site_url("Mechanic/observations") ?>'><?= translate('observation') ?></a></li>                    
            <li class="active"><?= translate('new_observation') ?></li>
        </ol>
    </div>
</div>

<div class="row">
    <!--<div class="col-md-2"></div>-->
    <div class="col-md-12">
        <div class="block">
            <div class="header">
                <h2><?= translate('new_activity_data') ?></h2>
            </div>
            <div class="content controls">
                <div class="col-md-4">
                    <?= translate('time_estimated_hr') ?>: &nbsp;<?= $operation->time_estimated_hours ?>
                </div>
                <div class="col-md-4">
                    <?= translate('time_used_hr') ?>: &nbsp; <?= $operation->time_used ?>
                </div>
                <div class="col-md-4">
                    <?= translate('state') ?>: &nbsp; <?= $operation->state ?>
                </div>
                <div class="col-md-12">
                    <?= translate('description') ?>: &nbsp;<?= $operation->description ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="block">
            <div class="header">
                <h2><?= translate('new_observation_data') ?></h2>
            </div>

            <div class="content controls">
                <div class="block">
                    <?php echo get_message_from_operation(); ?>
                </div>   
            </div>

            <div class="content controls">
                <form action="<?= site_url('Mechanic/new_observation_execute') ?>" method="post">
                    <div class="form-row">   
                        <div class="col-md-3"><?= translate('comment') ?>:</div>
                        <div class="col-md-9">                      
                            <textarea name="comment" rows="12" class="form-control"></textarea>
                        </div>                  
                    </div>
<!--                    <div class="form-row">   
                        <div class="col-md-3"><?= translate('state') ?>:</div>
                        <div class="col-md-9">
                            <div class="input-group">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <input type="radio" value="0" name="observation_state"  checked="checked">
                                        </span>
                                        <input type="text" class="form-control" aria-label="..." disabled="" value="<?= translate('state_pending') ?>">
                                    </div> /input-group 
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <input type="radio" value="1" name="observation_state">
                                        </span>
                                        <input type="text" class="form-control" aria-label="..." disabled="" value="<?= translate('state_finish') ?>">
                                    </div> /input-group 
                                </div>
                            </div>                  
                        </div> 
                    </div>-->
                    <div class="footer">
                        <div class="side pull-right">
                            <div class="btn-group">
                                <button class="btn btn-danger" type="button" onclick="window.history.back()"><?= translate('cancel') ?></button>
                                <button class="btn btn-success" type="submit"><?= translate('accept') ?></button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="operation_id" value=<?= $operation->operation_id ?> >
                </form>
            </div>
        </div>                           
    </div>
</div>
