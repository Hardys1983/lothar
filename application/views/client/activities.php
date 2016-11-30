
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type='text/javascript' src='<?= base_url('template/js/plugins/uniform/jquery.uniform.min.js') ?>'></script>
<script type='text/javascript' src='<?= base_url('template/js/plugins/datatables/jquery.dataTables.min.js') ?>'></script>

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">                    
            <li><a href="<?= site_url('Client/vehicles') ?>"><?= translate('vehicles') ?></a></li>                    
            <li><a href="<?= site_url('Client/works_by_vehicle/'.$car_id) ?>"><?= translate('work_order') ?></a></li>                    
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
            <div class="header">
                <h2><?= translate('activities') ?></h2>                                        
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
                                    <th><?= translate('responsible') ?></th>
                                    <th><?= translate('time_estimated_hr') ?></th>
                                    <th><?= translate('time_used_hr') ?></th>
                                    <th><?= translate('description') ?></th>
                                    <th><?= translate('price') ?></th>
                                    <th><?= translate("state") ?></th>
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
                                    <th><?= translate('responsible') ?></th>
                                    <th><?= translate('time_estimated_hr') ?></th>
                                    <th><?= translate('time_used_hr') ?></th>
                                    <th><?= translate('description') ?></th>
                                    <th><?= translate('price') ?></th>
                                    <th><?= translate("state") ?></th>
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
</script>
