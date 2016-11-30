<script type='text/javascript' src='<?= base_url('template/js/plugins/uniform/jquery.uniform.min.js') ?>'></script>
<script type='text/javascript' src='<?= base_url('template/js/plugins/datatables/jquery.dataTables.min.js') ?>'></script>

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">                    
            <li><a href="<?= site_url('Welcome/index') ?>">Dashboard</a></li>                    
            <li class="active"><?= translate('open_activities') ?></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="block">
            <div class="header">
                <h2>useres</h2>                                        
            </div>
            <div class="content">
                <table cellpadding="0" cellspacing="0" width="100%" class="table sortable">
                    <thead>
                        <tr>
                            <th><?= translate('operation_type') ?></th>
                            <th><?= translate('description') ?></th>
                            <th><?= translate('responsible') ?></th>
                            <th><?= translate('actions') ?></th>                                   
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($activities as $act): ?>
                            <tr>
                                <td><?= $act->operation_type ?></td>
                                <td><?= $act->description ?></td>
                                <td><?= $act->person ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button id="dLabel" type="button" class="btn btn-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <?= translate('select') ?>
                                            <span class="fa fa-plus"></span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                                            <li>
                                                <div class="content list">
                                                    <div class="list-info">
                                                        <p>
                                                            <?= translate('time_estimated_hr') ?>
                                                            <?= $act->time_estimated_hours ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="content list">
                                                    <div class="list-info">
                                                        <?= translate('price') ?>
                                                        <?= $act->price ?>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="content list">
                                                    <div class="list-info">
                                                        <a href="<?= site_url("Vehicular_reception/show_work_order/$act->work_order_id") ?>"
                                                </div>
                                            </div>
                                        </li>
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