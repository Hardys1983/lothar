<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type='text/javascript' src='<?= base_url('template/js/plugins/uniform/jquery.uniform.min.js') ?>'></script>
<script type='text/javascript' src='<?= base_url('template/js/plugins/datatables/jquery.dataTables.min.js') ?>'></script>

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">                    
            <li class="active"><?= translate('observations') ?></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
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

<div class="content controls">
    <div class="block">
        <?php echo get_message_from_operation(); ?>
    </div>   
</div>
<?php if (isset($operation->operation_id)) { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <a href='<?= site_url("Mechanic/new_observation/$operation->operation_id") ?>' class="btn btn-primary btn-clean"><i class="fa fa-plus"></i> <?= translate('add') ?></a> 
            </div>
        </div>
    </div>
<?php } ?>

<div class="row">
    <div class="col-md-12">
        <div class="block">
            <div class="header">
                <h2><?= translate('observations') ?></h2>                                        
            </div>
            <div class="content">
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs-1"><?= translate('state_pending') ?></a></li>
                        <li><a href="#tabs-2"><?= translate('state_finish') ?></a></li>
                    </ul>
                    <div id="tabs-1" style="display: inline-block">
                        <table cellpadding="0" cellspacing="0" width="100%" class="table sortable_mechanic_activites">
                            <thead>
                                <tr>
                                    <th><?= translate('operation_id') ?></th>
                                    <th><?= translate('state') ?></th>
                                    <th><?= translate('day') ?></th>
                                    <th><?= translate('comment') ?></th>
                                    <th><?= translate('actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($observations as $observation): ?>
                                    <?php if ($observation->observation_state == translate('state_pending')): ?>
                                        <tr>
                                            <td><?= $observation->operation_id ?></td>
                                            <td><?= $observation->observation_state ?></td>
                                            <td><?= $observation->day ?></td>
                                            <td><?= $observation->comment ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary btn-clean dropdown-toggle" data-toggle="dropdown">
                                                        <?= translate('select') ?>
                                                        <span class="fa fa-chevron-down"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a class="btn btn-warning" href="#" onclick="update('<?= $observation->observation_id ?>')"><?= translate('update') ?></a></li>
                                                        <li class="divider"></li>
                                                        <li><a class="btn btn-danger" href="#" onclick="erase('<?= $observation->observation_id ?>')"><?= translate('delete') ?></a></li>
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
                        <table cellpadding="0" cellspacing="0" width="100%" class="table sortable_mechanic_activites">
                            <thead>
                                <tr>
                                    <th><?= translate('operation_id') ?></th>
                                    <th><?= translate('state') ?></th>
                                    <th><?= translate('day') ?></th>
                                    <th><?= translate('comment') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($observations as $observation): ?>
                                    <?php if ($observation->observation_state == translate('state_finish')): ?>
                                        <tr>
                                            <td><?= $observation->operation_id ?></td>
                                            <td><?= $observation->observation_state ?></td>
                                            <td><?= $observation->day ?></td>
                                            <td><?= $observation->comment ?></td>
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
        $("#btn-delete").attr("href", "<?= site_url("Mechanic/erase_observation") ?>" + "/" + id);
        $("#confirm-delete").modal('show');
    }

    function update(id) {
        window.location.href = "<?= site_url('Mechanic/update_observation') ?>" + "/" + id;
    }

    function activities(id) {
        window.location.href = "<?= site_url("Mechanic/activities") ?>" + "/" + id;
    }

    $(function () {
        $("#tabs").tabs();
    });
</script>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <?= translate('delete_observation') ?>:
            </div>
            <div class="modal-body">
                <?= translate('delete_observation_question') ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?= translate('cancel') ?></button>
                <a id="btn-delete" class="btn btn-danger btn-ok"><?= translate('delete') ?></a>
            </div>
        </div>
    </div>
</div>