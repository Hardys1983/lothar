<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">                    
            <li><a href="<?= site_url('Welcome/index') ?>">Dashboard</a></li>                    
            <li><a href="<?= site_url('Vehicular_reception/index') ?>"><?= translate('work_orders') ?></a></li>
            <li><a href='<?= site_url("Vehicular_reception/activities/$activity->work_order_id") ?>'><?= translate('activities') ?></a></li>                    
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
            <form action="<?= site_url('Vehicular_reception/update_activity_execute') ?>" method="post">
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('activity_type') ?>:</div>
                    <div class="col-md-9">      
                        <select class="form-control" name="operation_type">
                            <option value="-1"><?= translate('select_activity_type') ?></option>
                            <?php
                            foreach ($operation_types as $operation):
                                $selected = "";
                                if ($operation->operation_type_id == $activity->operation_type_id) {
                                    $selected = "selected='selected'";
                                }
                                ?>

                                <option <?= $selected ?> value=<?= $operation->operation_type_id ?> > <?= $operation->comment ?></option>
                            <?php endforeach; ?>
                        </select>                
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('responsible') ?>:</div>
                    <div class="col-md-9">      
                        <select class="form-control" name="mechanic">
                            <option value="-1"><?= translate('select_responsible') ?></option>
                            <?php
                            foreach ($mechanics as $mechanic):
                                $selected = "";
                                if ($mechanic->person_id == $activity->person_id) {
                                    $selected = "selected='selected'";
                                }
                                ?>
                                <option <?= $selected ?> value=<?= $mechanic->person_id ?> > <?= $mechanic->name ?></option>
                            <?php endforeach; ?>
                        </select>                
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
                        <input name="time_estimated" value="<?= $activity->time_estimated_hours ?>" type="number" class="form-control">
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('price') ?>:</div>
                    <div class="col-md-9">                      
                        <input name="price" type="number" value="<?= $activity->price ?>" class="form-control">
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('state') ?>:</div>
                    <div class="col-md-9">
                        <div class="input-group">
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="radio" value="0" name="state"  <?php if ($activity->state == 0) {
                                echo "checked";
                            } ?>>
                                    </span>
                                    <input type="text" class="form-control" aria-label="..." disabled="" value="<?= translate('state_pending') ?>">
                                </div><!-- /input-group -->
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="radio" value="1" name="state" <?php if ($activity->state == 1) {
                                echo "checked";
                            } ?>>
                                    </span>
                                    <input type="text" class="form-control" aria-label="..." disabled="" value="<?= translate('state_finish') ?>">
                                </div><!-- /input-group -->
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="radio" value="2" name="state" <?php if ($activity->state == 2) {
                                echo "checked";
                            } ?>>
                                    </span>
                                    <input type="text" class="form-control" aria-label="..." disabled="" value="<?= translate('state_proposed') ?>">
                                </div><!-- /input-group -->
                            </div>
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
                <input type="hidden" name="activity_id" value=<?= $activity->operation_id ?> >
                <input type="hidden" name="work_order_id" value=<?= $activity->work_order_id ?> >

            </form>
        </div>
    </div>                           
</div>