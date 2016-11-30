<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">                    
            <li><a href='<?= site_url("Mechanic/activities") ?>'><?= translate('activities') ?></a></li>                    
            <li class="active"><?= translate('new_activity') ?></li>
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
            <form action="<?= site_url('Mechanic/new_activity_execute') ?>" method="post">
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('activity_type') ?>:</div>
                    <div class="col-md-9">      
                        <select class="form-control" name="operation_type">
                            <option value="-1"><?= translate('select_activity_type') ?></option>
                            <?php foreach ($operation_types as $operation): ?>
                                <option value=<?= $operation->operation_type_id ?> > <?= $operation->comment ?></option>
                            <?php endforeach; ?>
                        </select>                
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('work_order') ?>:</div>
                    <div class="col-md-9">      
                        <select class="form-control" name="work_order_id">
                            <option value="-1">--<?= translate('work_orders_selected') ?>--</option>
                            <?php foreach ($work_orders as $work): ?>
                                <option value=<?= $work->work_order_id ?> > <?= $work->text ?></option>
                            <?php endforeach; ?>
                        </select>                
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('description') ?>:</div>
                    <div class="col-md-9">                      
                        <input name="description" type="text" class="form-control">
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('time_estimated_hr') ?>:</div>
                    <div class="col-md-9">                      
                        <input name="time_estimated" type="number" class="form-control">
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

<script type="text/javascript">
    $(function () {
        function onClickToggle(object) {
            $(".togglable").prop("disabled", false);
            $(this).prop("disabled", true);
            //selectedState = $(this).attr("id");
        }
        $(".togglable").on('click', onClickToggle);
    });
</script>