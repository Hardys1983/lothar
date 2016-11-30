<script type='text/javascript' src='<?= base_url('template/js/plugins/uniform/jquery.uniform.min.js') ?>'></script>
<script type='text/javascript' src='<?= base_url('template/js/plugins/datatables/jquery.dataTables.min.js') ?>'></script>

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">                    
            <li><a href="<?= site_url('Client/vehicles') ?>"><?= translate('vehicles') ?></a></li>                    
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
                                        <span class="label label-danger"><?= translate('open') ?></span>
                                    <?php else: ?>
                                        <span class="label label-success"><?= translate('closed') ?></span>
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
                                            <span class="fa fa-plus"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a class="btn btn-primary" href="#" onclick="activities('<?= $work_order->work_order_id ?>')"><?= translate('activities') ?></a></li>
                                            <li class="divider"></li>
                                            <li><a class="btn btn-info" href="#" onclick="show('<?= $work_order->work_order_id ?>')"><?= translate('info') ?></a></li>
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
    function show(id) {
        window.location.href = "<?= site_url("Client/show_work_order") ?>" + "/" + id;
    }

    function activities(id) {
        window.location.href = "<?= site_url("Client/activities") ?>" + "/" + id;
    }
</script>