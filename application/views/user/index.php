<script type='text/javascript' src='<?= base_url('template/js/plugins/uniform/jquery.uniform.min.js') ?>'></script>
<script type='text/javascript' src='<?= base_url('template/js/plugins/datatables/jquery.dataTables.min.js') ?>'></script>

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">                    
            <li><a href="<?= site_url('Welcome/index') ?>">Dashboard</a></li>                    
            <li class="active"><?= translate('users') ?></li>
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
            <a href="<?= site_url('user/add') ?>" class="btn btn-primary btn-clean"><i class="fa fa-plus"></i> <?= translate('add') ?></a> 	
        </div>
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
                            <th></th>
                            <th><?= translate('full_name') ?></th>
                            <th><?= translate('ci') ?></th>
                            <th><?= translate('information') ?></th>
                            <th><?= translate('actions') ?></th>                                   
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td></td>
                                <td>
                                    <?= $user->name ?>
                                </td>
                                <td>	
                                    <?= $user->ci ?>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button id="dLabel" type="button" class="btn btn-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <?= translate('select') ?>
                                            <span class="fa fa-chevron-down"></span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                                            <li>
                                                <div class="content list">
                                                    <div class="list-info">
                                                        <p style="text-align:center; background-color: gray;">
                                                            <img src="<?= $user->image ?>" class="img-circle img-thumbnail">
                                                        </p>
                                                    </div>
                                                    <div class="list-item">
                                                        <div class="list-text">
                                                            <a href="#" class="list-text-name"><?= translate('address') ?></a>
                                                            <p><?= $user->address ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="list-item">
                                                        <div class="list-text">
                                                            <a href="#" class="list-text-name"><?= translate('email') ?></a>
                                                            <p><?= $user->email ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="list-item">
                                                        <div class="list-text">
                                                            <a href="#" class="list-text-name"><?= translate('phone') ?></a>
                                                            <p><?= $user->phone ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="list-item">
                                                        <div class="list-text">
                                                            <a href="#" class="list-text-name"><?= translate('cell_phone') ?></a>
                                                            <p><?= $user->cell_phone_co . ": " . $user->cell_phone ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </td> 
                                <td>
                                    <div class="row">
                                        <a href="<?= site_url('user/update/' . $user->person_id) ?>" class="btn btn-warning"><?= translate('update') ?></a>
                                        <a class="btn btn-danger" onclick="erase('<?= $user->person_id ?>')"><?= translate('delete') ?></a>
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
        $("#btn-delete").attr("href", "<?= site_url("user/erase") ?>" + "/" + id);
        $("#confirm-delete").modal('show');
    }

</script>



<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <?= translate('delete_user') ?>:
            </div>
            <div class="modal-body">
                <?= translate('delete_user_question') ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?= translate('cancel') ?></button>
                <a id="btn-delete" class="btn btn-danger btn-ok"><?= translate('delete') ?></a>
            </div>
        </div>
    </div>
</div>