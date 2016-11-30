<style type='text/css' src='<?php echo base_url('template/css/fullcalendar/fullcalendar.css') ?>'></style>
<style type='text/css' src='<?php echo base_url('template/css/jquery/jquery.timepicker.css') ?>'></style>
<script type='text/javascript' src='<?= base_url('template/js/plugins/fullcalendar/fullcalendar.min.js') ?>'></script>
<script type='text/javascript' src='<?= base_url('template/js/plugins/jquery/jquery.timepicker.min.js') ?>'></script>
<script type='text/javascript' src='<?= base_url('template/js/plugins/fullcalendar/moment.min.js') ?>'></script>

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">                    
            <li><a href='<?= site_url("Client/appointments") ?>'><?= translate('appointments') ?></a></li>                    
            <li class="active"><?= translate('new_appointment') ?></li>
        </ol>
    </div>
</div>

<div class="row">
    <!--<div class="col-md-2"></div>-->
    <div class="col-md-12">
        <div id='calendar_appointment'></div>
    </div>
    <div class="col-md-2"></div>
</div>

<style type="text/css">
    .modal-content .block{
        opacity: 1;
        background: #082648 url("../img/background/bg_num1.jpg") repeat-x scroll left top;
        padding: 20px;
    }
</style>

<script type="text/javascript">
    $('document').ready(function () {

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
            var base_url = "<?php echo site_url() ?>" + "/Client/appointments_json";
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

                    $("#horarios").load("<?php echo site_url() ?>/Client/horarios_disponibles", {day: start}, function (response, status, xhr) {
                        if (status == "error") {
                            var msg = "Error!, algo ha sucedido: ";
                            $("#horarios").html(msg + xhr.status + " " + xhr.statusText);
                        }
                    });
                    $("#confirm-appointment").modal('show');
                    calendar.fullCalendar('unselect');
                }
//                ,
//                drop: function (date, allDay) {
//
//                    var originalEventObject = $(this).data('eventObject');
//
//                    var copiedEventObject = $.extend({}, originalEventObject);
//
//                    copiedEventObject.start = date;
//                    copiedEventObject.allDay = allDay;
//
//                    $('#calendar_appointment').fullCalendar('renderEvent', copiedEventObject, true);
//
//
//                    if ($('#drop-remove').is(':checked')) {
//                        $(this).remove();
//                    }
//
//                }
            });
        }
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
                    <form action="<?= site_url('Client/new_appointment_execute') ?>" method="post">

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
                            <div class="col-md-3"><?= translate('vehicle') ?>:</div>
                            <div class="col-md-9">      
                                <select class="form-control" name="vehicle_id" required>
                                    <option value="-1">--<?= translate('vehicle_selected') ?>--</option>
                                    <?php foreach ($vehicles as $car): ?>
                                        <option value=<?= $car->vehicle_id ?> > <?= $car->vehicle_model ?></option>
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
                                                <input type="checkbox" value="1" name="taxi_required" >
                                            </span>
                                            <input type="text" class="form-control" aria-label="..." disabled="" value="<?= translate('taxi_required') ?>">
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