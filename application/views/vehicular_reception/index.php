<script type='text/javascript' src='<?= base_url('template/js/plugins/uniform/jquery.uniform.min.js') ?>'></script>
<script type='text/javascript' src='<?= base_url('template/js/plugins/datatables/jquery.dataTables.min.js') ?>'></script>

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">                    
            <li><a href="<?= site_url('Welcome/index') ?>">Dashboard</a></li>                    
            <li class="active"><?= translate('work_orders') ?></li>
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
            <a href="<?= site_url('Vehicular_reception/new_work_order') ?>" class="btn btn-primary btn-clean"><i class="fa fa-plus"></i> <?= translate('add') ?></a> 	
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="block">
            <div class="header">
                <h2><?= translate('work_orders') ?></h2>                                        
            </div>
            <div class="content">
                <table cellpadding="0" cellspacing="0" width="100%" class="table sortable_order">
                    <thead>
                        <tr> 
                            <th><?= translate('responsible') ?></th>
                            <th><?= translate('owner') ?></th>
                            <th><?= translate('plate_number') ?></th>
                            <th><?= translate('reception_date') ?></th>
                            <th><?= translate('actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($work_orders as $work_order): ?>
                            <tr>
                                <td>
                                    <?= $work_order->received_by; ?>
                                </td>
                                <td>	
                                    <?= $work_order->owner; ?>
                                </td>
                                <td>	
                                    <?= $work_order->vehicle->plate_number; ?>
                                </td>
                                <td>
                                    <?php if ($work_order->closed != '1'): ?>
                                        <span class="label label-success"><?= translate('open') ?></span>
                                    <?php else: ?>
                                        <span class="label label-danger"><?= translate('closed') ?></span>
                                    <?php endif; ?>
                                    <div class="panel-body">
                                        <?= $work_order->admission_day; ?>
                                    </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-clean dropdown-toggle" data-toggle="dropdown">
                                            <?= translate('select') ?>
                                            <span class="fa fa-chevron-down"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a class="btn btn-primary" href="#" onclick="activities('<?= $work_order->work_order_id ?>')"><?= translate('activities') ?></a></li>
                                            <li class="divider"></li>
                                            <li><a class="btn btn-info" href="#" onclick="show('<?= $work_order->work_order_id ?>')"><?= translate('info') ?></a></li>
                                            <li class="divider"></li>
                                            <li><a class="btn btn-info" href="<?= site_url("final_revision/add/$work_order->work_order_id") ?>"><?= translate('final_revision') ?></a></li>
                                            <li class="divider"></li>
                                            <li><a class="btn btn-danger" href="#" onclick="erase('<?= $work_order->work_order_id ?>')"><?= translate('delete') ?></a></li>
                                        </ul>
                                    </div>
                                </td> 
                            </tr>                         
                        <?php endforeach; ?>
                    </tbody>
                </table>                                        
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">

    function erase(id) {
        $("#btn-delete").attr("href", "<?= site_url("Vehicular_reception/erase") ?>" + "/" + id);
        $("#confirm-delete").modal('show');
    }

    function show(id) {
        window.location.href = "<?= site_url("Vehicular_reception/show_work_order") ?>" + "/" + id;
    }

    function activities(id) {
        window.location.href = "<?= site_url("Vehicular_reception/activities") ?>" + "/" + id;
    }


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