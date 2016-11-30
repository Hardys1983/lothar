<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">                    
            <li><a href="<?= site_url('Welcome/index') ?>">Dashboard</a></li>
            <li><a href="<?= site_url('Vehicular_reception/index') ?>"><?= translate('vehicular_orders') ?></a></li>
            <li class="active"><?= translate('new_work_order') ?></li>
        </ol>
    </div>
</div>

<!--<div class="col-md-2"></div>-->
<div class="col-md-12">
    <div class="block">
        <div class="header">
            <h2><?= translate('work_order') ?></h2>
        </div>

        <div class="content controls">
            <div class="block">
                <?php echo get_message_from_operation(); ?>
            </div>   
        </div>

        <div class="content controls">
            <form id="frmNewOrder" action="<?= site_url('Vehicular_reception/new_work_order_execute') ?>" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="col-md-3"><?= translate('responsible') ?>:</div>
                    <div class="col-md-9">
                        <input type="text" readonly class="form-control" value="<?= $this->session->userdata("name") ?>" ></div>
                </div>

                <input type="hidden" id="positions" name="positions" >
                <input type="hidden" name="dummy_order_id" value='<?= $dummy_order_id ?>'>

                <div class="form-row">
                    <div class="col-md-3"><?= translate('owner') ?>:</div>
                    <div class="col-md-9">
                        <select class="form-control" name="owner" id="owner">
                            <option value="-1">--<?= translate('select_owner') ?>--</option>
                            <?php foreach ($owners as $owner): ?>
                                <option value="<?= $owner->person_id ?>"><?= $owner->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div> 

                <div class="form-row">
                    <div class="col-md-3"><?= translate('vehicles') ?>:</div>
                    <div class="col-md-9">
                        <div class="content">
                            <div id="radio_button_collection" class="radiobox-inline">
                            </div>
                        </div>	                        
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-3"><?= translate('km_traveled') ?>:</div>
                    <div class="col-md-9">
                        <input id="spinner" type="text" class="form-control" name="km" value="0">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-3"><?= translate('fuel_level') ?>:</div>
                    <div class="col-md-9">
                        <select class="form-control" name="fuel_level" id="fuel_level">
                            <option value="-1">--<?= translate('fuel_level') ?>--</option>
                            <option value="0"><?= translate('empty') ?></option>          		                        	
                            <option value="25">25%</option>
                            <option value="50">50%</option>
                            <option value="75">75%</option>
                            <option value="100"><?= translate('full') ?></option>          		                        	
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-3"><?= translate('reception_reason') ?>:</div>
                    <div class="col-md-9">
                        <input type="text" class="form-control" value="" name="reason" required="required">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12"><?= translate('severity') ?>:</div>
                    <div class="col-md-12">
                        <div class="btn-group">
                            <button type="button" id="stateDanger" disabled class="btn btn-danger togglable"><?= translate('high') ?></button>
                            <button type="button" id="stateWarning" class="btn btn-warning togglable"><?= translate('moderate') ?></button>
                            <button type="button" id="stateInfo" class="btn btn-info togglable"><?= translate('low') ?></button>
                        </div>
                        <br>
                        <div>
                            <canvas id="canvasSignature" width="580px" height="835px" style="border:2px solid #000000; margin-top: 10px; background: url('<?= base_url('template/img/plano_car.jpg') ?>')">
                            </canvas>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <div class="side pull-right">
                        <div class="btn-group">
                            <button class="btn btn-danger" type="button" onclick="closeNewOrder()"><?= translate('cancel') ?></button>
                            <button class="btn btn-success" type="submit"><?= translate('accept') ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>  
    </div>
</div>                           
</div>

<div class="modal modal-draggable" id="point_properties" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">                
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?= translate('associate_image_point') ?></h4>
            </div>                
            <div class="modal-body clearfix">
                <div class="form-row">
                    <div class="col-md-3"><?= translate("image") ?></div>
                    <div class="col-md-9">
                        <div class="form-row">                                                                                
                            <img id="point_image" src="" class="img-square" style="width:400px;height:400px">
                        </div>
                        <div class="input-group file">                                    
                            <input type="text" class="form-control">
                            <input type="file" name="file" id="file" onchange='saveImage(event)'>
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button"><?= translate("search") ?></button>
                            </span>
                        </div>                                
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-clean btn-danger" data-dismiss="modal" id="delete_file"><?= translate('delete') ?></button>
                <button type="button" class="btn btn-clean btn-success" data-dismiss="modal" id="accept_file"><?= translate('accept') ?></button>              
                <button type="button" class="btn btn-clean btn-warning" data-dismiss="modal" id="warning_file"><?= translate('cancel') ?></button>  
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function setChecked(object) {
        $(".removeChecked").removeClass("checked");
        $(object).addClass("checked");
    }

    function closeNewOrder() {
        var url = '<?= site_url("Vehicular_reception/erase_all_images/$dummy_order_id") ?>';
        $.post(url, {}, function (result) {
        });
        window.history.back();
    }

    var context = null;
    var positions = [];
    var selectedIndex = -1;
    var currentFile = null;
    var nextId = 0;
    var selectedState = 1;

    function saveImage(event) {
        currentFile = event.target.files[0];
        $("#point_image").attr('src', URL.createObjectURL(currentFile));
    }

    $(function () {

        function onClickToggle(object) {
            $(".togglable").prop("disabled", false);
            $(this).prop("disabled", true);

            selectedState = $(this).attr("id");
        }

        $(".togglable").on('click', onClickToggle);

        $("#frmNewOrder").submit(function (event) {
            var values = "";
            for (var i = 0; i < positions.length; ++i) {
                values += (positions[i].ID + ";" + positions[i].X + ";" + positions[i].Y + ";" + positions[i].color + "|");
            }
            $("#positions").val(values);
        });

        $("#owner").on('change', function () {
            var owner_id = $(this).val();
            if (owner_id != -1) {
                $.post("<?= site_url('Vehicular_reception/get_owned_cars/') ?>", {owner_id: owner_id}, function (result) {
                    var cars = JSON.parse(result);

                    $("#radio_button_collection").empty();
                    var first = "<div class='radio'><span onclick='setChecked(this)' class='removeChecked'><input required='required' type='radio' name='vehicle_id'";
                    var middle = "></span></div>";
                    var second = "<br>";
                    var items = "";
                    for (var i = 0; i < cars.length; ++i) {
                        items += (first + " value = " + cars[i].vehicle_id + middle + cars[i].plate_number + second);
                    }
                    $("#radio_button_collection").html(items);
                });
            } else {
                $("#radio_button_collection").empty();
            }
        });

        //Global variables
        context = getContext();
        context.strokeStyle = 'Black';

        function drawPoint(text, point, context, color) {
            context.beginPath();
            context.fillStyle = color;

            context.arc(point.X, point.Y, 10, 0, 2 * Math.PI);
            context.fill();
            context.stroke();

            //draw number
            context.fillStyle = "#000000";
            context.textAlign = "center";
            context.fillText(text, point.X, point.Y + 4);
        }

        function drawPoints() {
            var context = getContext();
            context.clearRect(0, 0, getCanvas().width, getCanvas().height);
            for (var i = 0; i < positions.length; ++i) {
                drawPoint(positions[i].ID, positions[i], context, positions[i].color);
            }
        }

        function distance(a, b) {
            var dx = a.X - b.X;
            var dy = a.Y - b.Y;

            return Math.sqrt(dx * dx + dy * dy);
        }

        function getContext() {
            return getCanvas().getContext('2d');
        }

        function getCanvas() {
            return document.getElementById('canvasSignature');
        }

        function getPosition(mouseEvent, sigCanvas) {
            var x, y;
            if (mouseEvent.pageX != undefined && mouseEvent.pageY != undefined) {
                x = mouseEvent.pageX;
                y = mouseEvent.pageY;
            } else {
                x = mouseEvent.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
                y = mouseEvent.clientY + document.body.scrollTop + document.documentElement.scrollTop;
            }
            var offset = $("#canvasSignature").offset();
            return {X: x - offset.left, Y: y - offset.top};
        }

        function getPointIndex(point) {
            for (var i = 0; i < positions.length; ++i) {
                if (distance(point, positions[i]) <= 10) {
                    return i;
                }
            }
            return -1;
        }

        $('#point_properties').on('show.bs.modal', function () {
            $('#file').focus();
        });

        var okPressed = false;
        $('#point_properties').on('hidden.bs.modal', function () {
            if (okPressed) {
                okPressed = false;
                var imagePath = $("#file").val();
                var extension = imagePath.substring(imagePath.lastIndexOf('.') + 1).toLowerCase();

                if (['gif', 'jpg', 'png', 'jpeg'].indexOf(extension) != -1) {
                    if (selectedIndex >= 0 && selectedIndex < positions.length) {
                        positions[selectedIndex].filePath = currentFile;

                        var formData = new FormData();
                        formData.append("work_order_id", "<?= $dummy_order_id ?>");
                        formData.append("point_id", positions[selectedIndex].ID);
                        formData.append("file", currentFile);

                        var request = new XMLHttpRequest();
                        request.open("POST", "<?= site_url('Vehicular_reception/save_image') ?>", true);

                        request.onload = function (oEvent) {
                            if (request.status != 200) {
                                alert("Error " + request.status + " occurred uploading your file.<br \/>");
                            }
                        };
                        request.send(formData);
                    }
                } else {
                    $('#point_properties').modal('hide');
                    $('#point_properties').modal('show');
                }
            }
        });

        $("#accept_file").on('click', function () {
            okPressed = true;
        });

        $("#delete_file").on('click', function () {
            if (selectedIndex >= 0 && selectedIndex < positions.length) {
                $.post("<?= site_url('Vehicular_reception/erase_image') ?>",
                        {
                            work_order_id: '<?= $dummy_order_id ?>',
                            point_id: positions[selectedIndex].ID
                        },
                function (result) {
                    //alert(result);
                }
                );
                positions.splice(selectedIndex, 1);
                drawPoints();
            }
        });

        $("#canvasSignature").mousedown(function (mouseEvent) {
            var position = getPosition(mouseEvent, getCanvas());
            selectedIndex = getPointIndex(position);

            if (selectedIndex >= 0) {
                okPressed = false;
                if (positions[selectedIndex].filePath) {
                    $("#point_image").attr("src", URL.createObjectURL(positions[selectedIndex].filePath));
                } else {
                    $("#point_image").attr("src", "");
                }
                $('#point_properties').modal('show');
            } else {
                nextId += 1;
                var color = "#FF0000";
                if (selectedState == "stateInfo") {
                    color = "#0000FF";
                } else if (selectedState == "stateWarning") {
                    color = "#FFCC00";
                }

                drawPoint(nextId, position, context, color);
                positions.push({ID: nextId, X: position.X, Y: position.Y, filePath: "", color: color});
            }
        });
    });

</script>