<script type='text/javascript' src='<?= base_url('template/js/plugins/uniform/jquery.uniform.min.js') ?>'></script>
<script type='text/javascript' src='<?= base_url('template/js/plugins/datatables/jquery.dataTables.min.js') ?>'></script>

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">                    
            <li><a href="<?= site_url('Welcome/index') ?>">Dashboard</a></li>                    
            <li class="active"><?= translate('owners') ?></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="block">
            <div class="header">
                <h2><?= translate('owners') ?></h2>                                        
            </div>

            <div class="content">
                <form method="post" action="<?= site_url('Owner/get_by_owner') ?>">
                    <select name="owner_id">
                        <?php foreach ($users as $user): ?>
                            <option <?php
                            if (isset($owner_id) && $owner_id == $user->person_id) {
                                echo "selected='selected'";
                            }
                            ?>  value="<?= $user->person_id ?>"><?= $user->name ?></option>
                            <?php endforeach; ?>
                    </select>
                    <br>
                    <br>
                    <div class="col-md-5"></div>
                    <div class="col-md-2">
                        <input type="submit" class="btn btn-success" value="<?= translate('search_car') ?>">
                    </div>
                </form>
            </div>

            <div class="header">
                <h2><?= translate('vehicles') ?></h2>                                        
            </div>

            <?php if (isset($cars) && count($cars) > 0): ?>
                <div class="content">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table sortable">
                        <thead>
                            <tr>
                                <th></th>
                                <th><?= translate('plate_number') ?></th>
                                <th><?= translate('car_information') ?></th>
                                <th><?= translate('information') ?></th>
                                <th><?= translate('is_owner') ?></th>                                   
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cars as $car):
                                ?>
                                <tr>
                                    <td></td>
                                    <td>
                                        <?= $car->plate_number ?>
                                    </td>
                                    <td>
                                        <?= $car->vehicle_model ?>
                                    </td>
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
                                                            <p style="text-align:center; background-color: gray;">
                                                                <img src="<?= base_url("$car->url_qr") ?>" class="img-circle img-thumbnail">
                                                            </p>
                                                        </div>
                                                        <div class="list-item">
                                                            <div class="list-text">
                                                                <a href="#" class="list-text-name"><?= translate('chassis_number') ?></a>
                                                                <p><?= $car->chassis_number ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="list-item">
                                                            <div class="list-text">
                                                                <a href="#" class="list-text-name"><?= translate('engine_number') ?></a>
                                                                <p><?= $car->engine_number ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="list-item">
                                                            <div class="list-text">
                                                                <a href="#" class="list-text-name"><?= translate('total_km') ?></a>
                                                                <p><?= $car->total_km ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="list-item">
                                                            <div class="list-text" >
                                                                <a href="#" class="list-text-name"><?= translate('total_color') ?></a>
                                                                <p style="background-color: <?= $car->color; ?>; width:100%;">.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </td> 
                                    <td>
                                        <div class="row">
                                            <input type="checkbox" <?php
                                            if ($car->owner_id != NULL) {
                                                echo "checked";
                                            }
                                            ?> onclick="onChecked(this, '<?= $car->vehicle_id ?>')" >	                            	
                                        </div>
                                    </td>
                                </tr>                         
                            <?php endforeach; ?>
                        </tbody>
                    </table>   
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function onChecked(item, car_id) {
        var owner_id = $("select option:selected").val();
        $.post("<?= site_url('owner/toggle') ?>", {vehicle_id: car_id, owner_id: owner_id}, function (result) {
        });
    }
</script>