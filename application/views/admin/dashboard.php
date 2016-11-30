<!--<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
<script type='text/javascript' src='<?= base_url('template/js/plugins/highcharts/highcharts.js') ?>'></script>
<script type='text/javascript' src='<?= base_url('template/js/plugins/highcharts/modules/data.js') ?>'></script>
<script type='text/javascript' src='<?= base_url('template/js/plugins/highcharts/modules/exporting.js') ?>'></script>

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">                    
            <li class="active"><?= translate('dashboard') ?></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="block">
            <div class="content">
                <div id="work_order" class="table_dash"></div>
                <div id="operation" class="table_dash"></div>
                <div id="appointment" class="table_dash"></div>
                <div id="mechanics" class="table_dash"></div>
            </div>
        </div>
    </div>
</div>

<table id="operation_datatable" style="display: none">
    <thead>
        <tr>
            <th></th>
            <th>Creadas</th>
            <th>Cerradas</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($operations as $p) { ?>
            <tr>
                <th> - <?= $p['date'] ?></th>
                <td><?= $p['create'] ?></td>
                <td><?= $p['finish'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<table id="appointment_datatable" style="display: none">
    <thead>
        <tr>
            <th></th>
            <th>Reservadas</th>
            <th>Aprobados</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($appointments as $a) { ?>
            <tr>
                <th> - <?= $a['date'] ?></th>
                <td><?= $a['reserved'] ?></td>
                <td><?= $a['approved'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<table id="work_order_datatable" style="display: none">
    <thead>
        <tr>
            <th></th>
            <th>Admitidas</th>
            <th>Cerradas</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($work_orders as $w) { ?>
            <tr>
                <th> - <?= $w['date'] ?></th>
                <td><?= $w['addmision'] ?></td>
                <td><?= $w['closed'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<table id="mechanic_datatable" style="display: none">
    <thead>
        <tr>
            <th></th>
            <th>Admitidas</th>
            <th>Cerradas</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($mechanics as $m) { ?>
            <tr>
                <th> - <?= $m['name'] ?></th>
                <td><?= $m['assigned'] ?></td>
                <td><?= $m['finish'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function () {
        $('#operation').highcharts({
            data: {
                table: 'operation_datatable'
            },
            chart: {
                type: 'column'
            },
            series: [{
                    color: Highcharts.getOptions().colors[8]
                }, {
                    color: Highcharts.getOptions().colors[1]
                }],
            title: {
                text: '<?php echo translate('dash_operation') ?>'
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'Cantidad'
                }
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                            this.point.y + ' ' + this.point.name.toLowerCase();
                }
            }
        });

        $('#appointment').highcharts({
            data: {
                table: 'appointment_datatable'
            },
            chart: {
                type: 'column'
            },
            series: [{
                    color: Highcharts.getOptions().colors[8]
                }, {
                    color: Highcharts.getOptions().colors[1]
                }],
            title: {
                text: '<?php echo translate('dash_appointment') ?>'
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'Cantidad'
                }
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                            this.point.y + ' ' + this.point.name.toLowerCase();
                }
            }
        });

        $('#work_order').highcharts({
            data: {
                table: 'work_order_datatable'
            },
            chart: {
                type: 'column'
            },
            series: [{
                    color: Highcharts.getOptions().colors[8]
                }, {
                    color: Highcharts.getOptions().colors[1]
                }],
            title: {
                text: '<?php echo translate('dash_work_order') ?>'
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'Cantidad'
                }
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                            this.point.y + ' ' + this.point.name.toLowerCase();
                }
            }
        });

        $('#mechanics').highcharts({
            data: {
                table: 'mechanic_datatable'
            },
            chart: {
                type: 'column'
            },
            series: [{
                    color: Highcharts.getOptions().colors[8]
                }, {
                    color: Highcharts.getOptions().colors[1]
                }],
            title: {
                text: '<?php echo translate('mechanic_operation') ?>'
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'Cantidad'
                }
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                            this.point.y + ' ' + this.point.name.toLowerCase();
                }
            }
        });
    });
</script>
