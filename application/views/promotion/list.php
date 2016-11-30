<!--<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
<script type='text/javascript' src='<?= base_url('template/js/plugins/uniform/jquery.uniform.min.js') ?>'></script>
<script type='text/javascript' src='<?= base_url('template/js/plugins/datatables/jquery.dataTables.min.js') ?>'></script>

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">                    
            <li class="active"><?= translate('promotion') ?></li>
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
            <a href='<?= site_url("Promotion/new_promotion") ?>' class="btn btn-primary btn-clean"><i class="fa fa-plus"></i> <?= translate('new_promotion') ?></a> 	
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="block">
            <div class="header">
                <h2><?= translate('promotions') ?></h2>                                        
            </div>
            <div class="content">
                <table cellpadding="0" cellspacing="0" width="100%" class="table sortable_mechanic_activites">
                    <thead>
                        <tr>
                            <th><?= translate('image') ?></th>
                            <th><?= translate("description") ?></th>
                            <th><?= translate('begin') ?></th>
                            <th><?= translate('end') ?></th>
                            <th><?= translate('actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($promotion as $new): ?>

                            <tr>
                                <td><img class="image_promotion_list" src="<?= base_url() . $new->picture ?>"></td>
                                <td><?= substr($new->description, 0, 400) ?></td>
                                <td><?= $new->begin ?></td>
                                <td><?= $new->end ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-clean dropdown-toggle" data-toggle="dropdown">
                                            <?= translate('select') ?>
                                            <span class="fa fa-chevron-down"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a class="btn btn-warning" href="#" onclick="update('<?= $new->promotion_id ?>')"><?= translate('update') ?></a></li>
                                            <li class="divider"></li>
                                            <li><a class="btn btn-danger" href="#" onclick="erase('<?= $new->promotion_id ?>')"><?= translate('delete') ?></a></li>
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
    $(function () {
        $("#tabs").tabs();
    });

    function erase(id) {
        $("#btn-delete").attr("href", "<?= site_url("Promotion/erase_promotion") ?>" + "/" + id);
        $("#confirm-delete").modal('show');
    }

    function update(id) {
        window.location.href = "<?= site_url('Promotion/update_promotion') ?>" + "/" + id;
    }

    $(function () {
        $("#tabs").tabs();
    });
</script>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <?= translate('delete_promotion') ?>:
            </div>
            <div class="modal-body">
                <?= translate('delete_promotion_question') ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?= translate('cancel') ?></button>
                <a id="btn-delete" class="btn btn-danger btn-ok"><?= translate('delete') ?></a>
            </div>
        </div>
    </div>
</div>
