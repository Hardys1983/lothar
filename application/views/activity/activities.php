
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type='text/javascript' src='<?= base_url('template/js/plugins/uniform/jquery.uniform.min.js') ?>'></script>
<script type='text/javascript' src='<?= base_url('template/js/plugins/datatables/jquery.dataTables.min.js') ?>'></script>

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">                    
            <li><a href="<?= site_url('Welcome/index') ?>">Dashboard</a></li>                    
            <li><a href="<?= site_url('Vehicular_reception/index') ?>"><?= translate('work_orders') ?></a></li>                    
            <li class="active"><?= translate('activities') ?></li>
        </ol>
    </div>
</div>

<div class="content controls">
    <div class="block">
        <?php echo get_message_from_operation(); ?>
    </div>   
</div>

<div class="row">
    <div class="col-md-12">
        <div class="block">
            <a href='<?= site_url("Vehicular_reception/new_activity/$work_order->work_order_id") ?>' class="btn btn-primary btn-clean"><i class="fa fa-plus"></i> <?= translate('add') ?></a> 	
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="block">
            <div class="header">
                <h2><?= translate('activities') ?></h2>                                        
            </div>
            <div class="content">
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs-1"><?= translate('state_pending') ?></a></li>
                        <li><a href="#tabs-2"><?= translate('state_finish') ?></a></li>
                        <li><a href="#tabs-3"><?= translate('state_proposed') ?></a></li>
                    </ul>
                    <div id="tabs-1" style="display: inline-block">
                        <table cellpadding="0" cellspacing="0" width="100%" class="table sortable">
                            <thead>
                                <tr>
                                    <th><?= translate('responsible') ?></th>
                                    <th><?= translate('time_estimated_hr') ?></th>
                                    <th><?= translate('time_used_hr') ?></th>
                                    <th><?= translate('description') ?></th>
                                    <th><?= translate('price') ?></th>
                                    <th><?= translate("state") ?></th>
                                    <th><?= translate("actions") ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($activities as $activity): ?>
                                    <?php if ($activity->state == translate('state_pending')): ?>
                                        <tr>
                                            <td><?= $activity->responsible ?></td>
                                            <td><?= $activity->time_estimated_hours ?></td>
                                            <td><?= $activity->time_used ?></td>
                                            <td><?= $activity->description ?></td>
                                            <td><?= $activity->price ?></td>
                                            <td><?= $activity->state ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary btn-clean dropdown-toggle" data-toggle="dropdown">
                                                        <?= translate('select') ?>
                                                        <span class="fa fa-chevron-down"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a class="btn btn-warning" href="#" onclick="update('<?= $activity->operation_id ?>')"><?= translate('update') ?></a></li>
                                                        <li class="divider"></li>
                                                        <li><a class="btn btn-success" href="#" onclick="observation('<?= $activity->operation_id ?>')"><?= translate('observation') ?></a></li>
                                                        <li class="divider"></li>
                                                        <li><a class="btn btn-danger" href="#" onclick="erase('<?= $activity->operation_id ?>')"><?= translate('delete') ?></a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>      
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table> 
                    </div>
                    <div id="tabs-2" style="display: inline-block">
                        <table cellpadding="0" cellspacing="0" width="100%" class="table sortable">
                            <thead>
                                <tr>
                                    <th><?= translate('responsible') ?></th>
                                    <th><?= translate('time_estimated_hr') ?></th>
                                    <th><?= translate('time_used_hr') ?></th>
                                    <th><?= translate('description') ?></th>
                                    <th><?= translate('price') ?></th>
                                    <th><?= translate("state") ?></th>
                                    <th><?= translate("actions") ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($activities as $activity): ?>
                                    <?php if ($activity->state == translate('state_finish')): ?>
                                        <tr>
                                            <td><?= $activity->responsible ?></td>
                                            <td><?= $activity->time_estimated_hours ?></td>
                                            <td><?= $activity->time_used ?></td>
                                            <td><?= $activity->description ?></td>
                                            <td><?= $activity->price ?></td>
                                            <td><?= $activity->state ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary btn-clean dropdown-toggle" data-toggle="dropdown">
                                                        <?= translate('select') ?>
                                                        <span class="fa fa-chevron-down"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a class="btn btn-warning" href="#" onclick="update('<?= $activity->operation_id ?>')"><?= translate('update') ?></a></li>
                                                        <li class="divider"></li>
                                                        <li><a class="btn btn-success" href="#" onclick="observation('<?= $activity->operation_id ?>')"><?= translate('observation') ?></a></li>
                                                        <li class="divider"></li>
                                                        <li><a class="btn btn-danger" href="#" onclick="erase('<?= $activity->operation_id ?>')"><?= translate('delete') ?></a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>      
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table> 
                    </div>
                    <div id="tabs-3" style="display: inline-block">
                        <table cellpadding="0" cellspacing="0" width="100%" class="table sortable">
                            <thead>
                                <tr>
                                    <th><?= translate('responsible') ?></th>
                                    <th><?= translate('time_estimated_hr') ?></th>
                                    <th><?= translate('time_used_hr') ?></th>
                                    <th><?= translate('description') ?></th>
                                    <th><?= translate('price') ?></th>
                                    <th><?= translate("state") ?></th>
                                    <th><?= translate("actions") ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($activities as $activity): ?>
                                    <?php if ($activity->state == translate('state_proposed')): ?>
                                        <tr>
                                            <td><?= $activity->responsible ?></td>
                                            <td><?= $activity->time_estimated_hours ?></td>
                                            <td><?= $activity->time_used ?></td>
                                            <td><?= $activity->description ?></td>
                                            <td><?= $activity->price ?></td>
                                            <td><?= $activity->state ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary btn-clean dropdown-toggle" data-toggle="dropdown">
                                                        <?= translate('select') ?>
                                                        <span class="fa fa-chevron-down"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a class="btn btn-warning" href="#" onclick="update('<?= $activity->operation_id ?>')"><?= translate('update') ?></a></li>
                                                        <li class="divider"></li>
                                                        <li><a class="btn btn-success" href="#" onclick="observation('<?= $activity->operation_id ?>')"><?= translate('observation') ?></a></li>
                                                        <li class="divider"></li>
                                                        <li><a class="btn btn-danger" href="#" onclick="erase('<?= $activity->operation_id ?>')"><?= translate('delete') ?></a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>    
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function erase(id) {
        $("#btn-delete").attr("href", "<?= site_url("Vehicular_reception/erase_activity") ?>" + "/" + id);
        $("#confirm-delete").modal('show');
    }

    function update(id) {
        window.location.href = "<?= site_url('Vehicular_reception/update_activity') ?>" + "/" + id;
    }
    
    function observation(id) {
        window.location.href = "<?= site_url('Vehicular_reception/observation_by_activity') ?>" + "/" + id;
    }

    function activities(id) {
        window.location.href = "<?= site_url("Vehicular_reception/activities") ?>" + "/" + id;
    }


    $(function () {
        $("#tabs").tabs();
    });


</script>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <?= translate('delete_work_order') ?>:
            </div>
            <div class="modal-body">
                <?= translate('delete_work_order_question') ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?= translate('cancel') ?></button>
                <a id="btn-delete" class="btn btn-danger btn-ok"><?= translate('delete') ?></a>
            </div>
        </div>
    </div>
</div>