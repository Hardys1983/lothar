<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Notificaciones</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Crear notificación
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form role="form" method="post" enctype="multipart/form-data" action="<?= site_url('notification/send');?>">
                                <div class="form-group">
                                    <label>Encabezado</label>
                                    <input type="text" class="form-control" name="header">
                                </div>
                                
                                <div class="form-group">
                                    <label>Texto</label>
                                    <input type="text" class="form-control" name="description" />
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

</div>