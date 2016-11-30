<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">                    
            <li><a href="<?= site_url('Client/vehicles') ?>"><?= translate('vehicles') ?></a></li>                    
            <li><a href="<?= site_url('Client/works_by_vehicle/'.$work_order->vehicle_id) ?>"><?= translate('work_order') ?></a></li>                    
            <li class="active"><?= translate('info') ?></li>
        </ol>
    </div>
</div>

<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="block">
        <div class="header">
            <h2><?= translate('work_order_information') ?></h2>
        </div>
        <div class="content controls">
            <div class="form-row">
                <div class="col-md-3"><?= translate('work_order_number') ?>:</div>
                <div class="col-md-9">
                    <input readonly type="text" value='<?= $work_order->work_order_id ?>' />
                </div>
            </div>	

            <div class="form-row">
                <div class="col-md-3"><?= translate('plate_number') ?>:</div>
                <div class="col-md-9">
                    <input readonly type="text" value='<?= $work_order->vehicle->plate_number ?>' />
                </div>
            </div>	

            <div class="form-row">
                <div class="col-md-3"><?= translate('owner') ?>:</div>
                <div class="col-md-9">
                    <input readonly type="text" value='<?= $work_order->owner ?>' />
                </div>
            </div>	

            <div class="form-row">
                <div class="col-md-3"><?= translate('responsible') ?>:</div>
                <div class="col-md-9">
                    <input readonly type="text" value='<?= $work_order->received_by ?>' />
                </div>
            </div>	

            <div class="form-row">
                <div class="col-md-3"><?= translate('reception_reason') ?>:</div>
                <div class="col-md-9">
                    <input readonly type="text" value='<?= $work_order->what_to_do ?>' />
                </div>
            </div>	

            <div class="form-row">
                <div class="col-md-3"><?= translate('fuel_level') ?>:</div>
                <div class="col-md-9">
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:<?= $work_order->fuel_level ?>%">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-3"><?= translate('severity') ?>:</div>
                <div class="col-md-9">
                    <div class="button-group">
                        <button type="button" id="stateDanger" class="btn btn-danger togglable"><?= translate('high') ?></button>
                        <button type="button" id="stateWarning" class="btn btn-warning togglable"><?= translate('moderate') ?></button>
                        <button type="button" id="stateInfo" class="btn btn-info togglable"><?= translate('low') ?></button>
                    </div>
                </div>
            </div>		

            <div class="form-row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <canvas id="canvasSignature" width="500px" height="500px" style="border:2px solid #000000;">
                    </canvas>
                </div>
            </div>
            <div class="footer">
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
                <h4 class="modal-title"><?= translate('associate_image') ?></h4>
            </div>                
            <div class="modal-body clearfix">
                <div class="form-row">
                    <p style="text-align: center">
                        <img id="point_image" src="" class="img-square" style="width:400px;height:400px">
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-clean btn-success" data-dismiss="modal"><?= translate('close') ?></button>              
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    var context = null;
    var positions = [];
    var selectedIndex = -1;
    var currentFile = null;
    var nextId = 0;

    function initialize() {
        var data = JSON.parse('<?= $points ?>');

        for (var i = 0; i < data.length; ++i) {
            positions.push({ID: i, X: data[i].X, Y: data[i].Y, filePath: data[i].picture, color: data[i].color});
        }
    }

    function drawPoint(text, point, context, color) {
        context.beginPath();
        context.fillStyle = color;

        context.arc(point.X, point.Y - 4, 10, 0, 2 * Math.PI);
        context.fill();
        context.stroke();

        //draw number
        context.fillStyle = "#000000";
        context.textAlign = "center";

        context.fillText(text, point.X, point.Y);
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

    $(function () {
        context = getContext();
        context.strokeStyle = 'Black';

        $("#canvasSignature").mousedown(function (mouseEvent) {
            var position = getPosition(mouseEvent, getCanvas());
            selectedIndex = getPointIndex(position);

            if (selectedIndex >= 0) {
                if (positions[selectedIndex].filePath) {
                    $("#point_image").attr("src", positions[selectedIndex].filePath);
                } else {
                    $("#point_image").attr("src", "");
                }
                $('#point_properties').modal('show');
            }
        });
        initialize();
        drawPoints();
    });
</script>