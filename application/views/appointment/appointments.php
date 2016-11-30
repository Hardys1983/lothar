<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type='text/javascript' src='<?= base_url('template/js/plugins/uniform/jquery.uniform.min.js') ?>'></script>
<script type='text/javascript' src='<?= base_url('template/js/plugins/datatables/jquery.dataTables.min.js') ?>'></script>

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">                    
            <li class="active"><?= translate('appointments') ?></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="container">
        <div class="block">
            <?php echo get_message_from_operation(); ?>
        </div>   
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="block">
            <a href='<?= site_url("Appointment/new_appointment") ?>' class="btn btn-primary btn-clean"><i class="fa fa-plus"></i> <?= translate('new_appointment') ?></a> 	
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="block">
            <div class="header">
                <h2><?= translate('appointments') ?></h2>                                        
            </div>
            <div class="content">
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs-1"><?= translate('state_pending') ?></a></li>
                        <li><a href="#tabs-2"><?= translate('state_approved') ?></a></li>
                    </ul>
                    <div id="tabs-1" style="display: inline-block">
                        <table cellpadding="0" cellspacing="0" width="100%" class="table sortable_mechanic_activites">
                            <thead>
                                <tr>
                                    <th><?= translate('day') ?></th>
                                    <th><?= translate("owner") ?></th>
                                    <th><?= translate('taxi') ?></th>
                                    <th><?= translate('address') ?></th>
                                    <th><?= translate('phone') ?></th>
                                    <th><?= translate('comment') ?></th>
                                    <th><?= translate("vehicle_model") ?></th>
                                    <th><?= translate("actions") ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($appointments as $appointment): ?>
                                    <?php if ($appointment->state == translate('state_pending')): ?>
                                        <tr>
                                            <td><?= $appointment->day ?></td>
                                            <td><?= $appointment->person ?></td>
                                            <td><?= $appointment->taxi_required ?></td>
                                            <td><?= $appointment->address ?></td>
                                            <td><?= $appointment->phone ?></td>
                                            <td><?= $appointment->comment ?></td>
                                            <td><?= $appointment->vehicle_model ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary btn-clean dropdown-toggle" data-toggle="dropdown">
                                                        <?= translate('select') ?>
                                                        <span class="fa fa-chevron-down"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a class="btn btn-warning" href="#" onclick="update('<?= $appointment->appointment_id ?>')"><?= translate('update') ?></a></li>
                                                        <li class="divider"></li>
                                                        <li><a class="btn btn-danger" href="#" onclick="erase('<?= $appointment->appointment_id ?>')"><?= translate('delete') ?></a></li>
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
                                    <th><?= translate('day') ?></th>
                                    <th><?= translate("owner") ?></th>
                                    <th><?= translate('taxi') ?></th>
                                    <th><?= translate('address') ?></th>
                                    <th><?= translate('phone') ?></th>
                                    <th><?= translate('comment') ?></th>
                                    <th><?= translate("vehicle_model") ?></th>
                                     <th><?= translate("actions") ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($appointments as $appointment): ?>
                                    <?php if ($appointment->state == translate('state_approved')): ?>
                                        <tr>
                                            <td><?= $appointment->day ?></td>
                                            <td><?= $appointment->person ?></td>
                                            <td><?= $appointment->taxi_required ?></td>
                                            <td><?= $appointment->address ?></td>
                                            <td><?= $appointment->phone ?></td>
                                            <td><?= $appointment->comment ?></td>
                                            <td><?= $appointment->vehicle_model ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary btn-clean dropdown-toggle" data-toggle="dropdown">
                                                        <?= translate('select') ?>
                                                        <span class="fa fa-chevron-down"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a class="btn btn-warning" href="#" onclick="update('<?= $appointment->appointment_id ?>')"><?= translate('update') ?></a></li>
                                                        <li class="divider"></li>
                                                        <li><a class="btn btn-danger" href="#" onclick="erase('<?= $appointment->appointment_id ?>')"><?= translate('delete') ?></a></li>
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
    $(function () {
        $("#tabs").tabs();
    });

    function erase(id) {
        $("#btn-delete").attr("href", "<?= site_url("Appointment/erase_appointment") ?>" + "/" + id);
        $("#confirm-delete").modal('show');
    }

    function update(id) {
        window.location.href = "<?= site_url('Appointment/update_appointment') ?>" + "/" + id;
    }

    $(function () {
        $("#tabs").tabs();
    });
</script>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <?= translate('delete_appointment') ?>:
            </div>
            <div class="modal-body">
                <?= translate('delete_appointment_question') ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?= translate('cancel') ?></button>
                <a id="btn-delete" class="btn btn-danger btn-ok"><?= translate('delete') ?></a>
            </div>
        </div>
    </div>
</div>