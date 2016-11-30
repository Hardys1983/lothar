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

<div class="row">
    <!--<div class="col-md-2"></div>-->
    <div class="col-md-12">
        <div id='calendar_appointment'></div>
    </div>
    <!--<div class="col-md-2"></div>-->
</div>
<br><br><br>

<style type="text/css">
    .modal-content .block{
        opacity: 1;
        background: #082648 url('<?php echo base_url() ?>/template/img/background/bg_num1.jpg') repeat-x scroll left top;
        //padding: 20px;
    }
</style>

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
        change_vehicles();
        if ($("#calendar_appointment").length > 0) {
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();
            $('#external-events .external-event').each(function () {
                var eventObject = {title: $.trim($(this).text())};
                $(this).data('eventObject', eventObject);
                $(this).draggable({
                    zIndex: 999,
                    revert: true,
                    revertDuration: 0
                });
            });
            var base_url = "<?php echo site_url() ?>" + "/Appointment/appointments_json";
            var calendar = $('#calendar_appointment').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                editable: false,
                eventLimit: true, // allow "more" link when too many events
                events: {
                    url: base_url,
                    error: function () {
                        $('#script-warning').show();
                    }
                },
                droppable: false,
                selectable: true,
                selectHelper: false,
                select: function (start, end, allDay) {

                    $("#horarios").load("<?php echo site_url() ?>/Appointment/horarios_disponibles", {day: start}, function (response, status, xhr) {
                        if (status == "error") {
                            var msg = "Error!, algo ha sucedido: ";
                            $("#horarios").html(msg + xhr.status + " " + xhr.statusText);
                        }
                    });
                    $("#confirm-appointment").modal('show');
                    calendar.fullCalendar('unselect');
                }
            });
        }

        $("#client_id").change(function () {
            change_vehicles();
        });
    });
</script>

<div class="modal fade" id="confirm-appointment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="block">
                <div class="header">
                    <h2><?= translate('new_appointment') ?></h2>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
                            </div>                  
                        </div>
                        <div class="form-row">
                            <div class="col-md-3"><?= translate('phone') ?>:</div>
                            <div class="col-md-9">                      
                                <input type="number" name="phone" required>
                            </div>                  
                        </div>
                        <div class="form-row">   
                            <div class="col-md-3"><?= translate('comment') ?>:</div>
                            <div class="col-md-9">                      
                                <textarea name="comment" rows="12" class="form-control"></textarea>
                            </div>                  
                        </div>
                        <div class="form-row">   
                            <div class="col-md-3"><?= translate('address') ?>:</div>
                            <div class="col-md-9">                      
                                <textarea name="address" rows="8" class="form-control" required></textarea>
                            </div>                  
                        </div>
                        <div class="form-row">   
                            <div class="col-md-3"><?= translate('owners') ?>:</div>
                            <div class="col-md-9">      
                                <select class="form-control" name="client_id" required id="client_id">
                                    <?php foreach ($owners as $o): ?>
                                        <option value=<?= $o->person_id ?> > <?= $o->name ?></option>
                                    <?php endforeach; ?>
                                </select>                
                            </div>                  
                        </div>
                        <div class="form-row">   
                            <div class="col-md-3"><?= translate('vehicles') ?>:</div>
                            <div class="col-md-9" id="vehicle_id">      
                                <select class="form-control" name="vehicle_id" required>
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
                                                <input type="checkbox" value="1" name="taxi_required" >
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
                                                <input type="radio" value="0" checked="" name="state" >
                                            </span>
                                            <input type="text" class="form-control" aria-label="..." disabled="" value="<?= translate('state_pending') ?>">
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <input type="radio" value="3" name="state" >
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
    </div>
</div>