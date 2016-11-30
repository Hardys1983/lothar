<style type='text/css' src='<?php echo base_url('template/css/fullcalendar/fullcalendar.css') ?>'></style>
<style type='text/css' src='<?php echo base_url('template/css/jquery/jquery.timepicker.css') ?>'></style>
<script type='text/javascript' src='<?= base_url('template/js/plugins/fullcalendar/fullcalendar.min.js') ?>'></script>
<script type='text/javascript' src='<?= base_url('template/js/plugins/jquery/jquery.timepicker.min.js') ?>'></script>
<script type='text/javascript' src='<?= base_url('template/js/plugins/fullcalendar/moment.min.js') ?>'></script>

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">                    
            <li><a href='<?= site_url("Appointment/appointments") ?>'><?= translate('appointments') ?></a></li>                    
            <li class="active"><?= translate('new_appointment') ?></li>
        </ol>
    </div>
</div>

<!--<div class="col-md-2"></div>-->
<div class="col-md-12">
    <div class="block">
        <div class="header">
            <h2><?= translate('update_appointment') ?></h2>
        </div>

        <div class="content controls">
            <div class="block">
                <?php echo get_message_from_operation(); ?>
            </div>   
        </div>

        <div class="content controls">
            <form action="<?= site_url('Appointment/new_appointment_execute') ?>" method="post">
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('time') ?>:</div>
                    <div class="col-md-9" id="horarios">   
                        <input type='text' class="form-control" id='datetimepicker' name="day" />
                    </div>  
                </div>
                <input type="hidden" id="day_actual" value="<?= $date ?>">
                <div class="form-row">
                    <div class="col-md-3"><?= translate('phone') ?>:</div>
                    <div class="col-md-9">                      
                        <input type="number" name="phone" required value="<?= $appointment->phone ?>">
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('comment') ?>:</div>
                    <div class="col-md-9">                      
                        <textarea name="comment" rows="12" class="form-control" ><?= $appointment->comment ?></textarea>
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('address') ?>:</div>
                    <div class="col-md-9">                      
                        <textarea name="address" rows="8" class="form-control" required> <?= $appointment->phone ?></textarea>
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('owners') ?>:</div>
                    <div class="col-md-9">      
                        <select class="form-control" name="client_id" required id="client_id">
                            <?php foreach ($clients as $o): ?>
                                <option value='<?= $o->person_id ?>' <?php
                                if ($o->person_id == $appointment->client_id) {
                                    echo 'selected =""';
                                }
                                ?> > <?= $o->name ?></option>
                                    <?php endforeach; ?>
                        </select>                
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('vehicles') ?>:</div>
                    <div class="col-md-9" id="vehicle_id">      
                        <select class="form-control" name="vehicle_id" required>
                            <?php foreach ($vehicles as $v): ?>
                                <option value="<?= $v->vehicle_id ?>" <?php
                                if ($v->vehicle_id == $appointment->vehicle_id) {
                                    echo 'selected =""';
                                }
                                ?> > <?= $v->vehicle_model ?></option>
                                    <?php endforeach; ?>
                        </select>                
                    </div>                  
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('taxi') ?>:</div>
                    <div class="col-md-9">
                        <div class="input-group">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="checkbox" value="1" name="taxi_required"  <?php
                                        if (1 == $appointment->taxi_required) {
                                            echo "checked";
                                        }
                                        ?> >
                                    </span>
                                    <input type="text" class="form-control" aria-label="..." disabled="" value="<?= translate('taxi_required') ?>">
                                </div> 
                            </div>
                        </div>                  
                    </div> 
                </div>
                <div class="form-row">   
                    <div class="col-md-3"><?= translate('state') ?>:</div>
                    <div class="col-md-9">
                        <div class="input-group">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="radio" value="0" name="state" <?php
                                        if (0 == $appointment->state) {
                                            echo "checked";
                                        }
                                        ?>>
                                    </span>
                                    <input type="text" class="form-control" aria-label="..." disabled="" value="<?= translate('state_pending') ?>">
                                </div> 
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="radio" value="3" name="state"  <?php
                                        if (3 == $appointment->state) {
                                            echo "checked";
                                        }
                                        ?>>
                                    </span>
                                    <input type="text" class="form-control" aria-label="..." disabled="" value="<?= translate('state_approved') ?>">
                                </div> 
                            </div>
                        </div>                  
                    </div> 
                </div>
                <div class="footer">
                    <div class="side pull-right">
                        <div class="btn-group">
                            <button class="btn btn-danger" type="button" class="close" data-dismiss="modal" aria-hidden="true"><?= translate('cancel') ?></button>
                            <button class="btn btn-success" type="submit"><?= translate('accept') ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function change_vehicles() {
        $("#vehicle_id").load("<?php echo site_url() ?>/Appointment/vehicles_by_owner", {client_id: $("#client_id").val()}, function (response, status, xhr) {
            if (status == "error") {
                var msg = "Error!, algo ha sucedido: ";
                $("#horarios").html(msg + xhr.status + " " + xhr.statusText);
            }
        });
    }

    $('document').ready(function () {
        $("#client_id").change(function () {
            change_vehicles();
        });

    });
</script>