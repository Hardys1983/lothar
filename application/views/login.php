<!DOCTYPE html>
<html lang="en">
    <head>    
        <title>Taurus</title>    
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="icon" type='image/ico' href="<?= base_url('template/favicon.ico') ?>"/>
        <link href="<?= base_url('template/css/stylesheets.css') ?>" rel="stylesheet" type="text/css" />        
        <script type='text/javascript' src='<?= base_url('template/js/plugins/jquery/jquery.min.js') ?>'></script>
        <script type='text/javascript' src='<?= base_url('template/js/plugins/jquery/jquery-ui.min.js') ?>'></script>
        <script type='text/javascript' src='<?= base_url('template/js/plugins/jquery/jquery-migrate.min.js') ?>'></script>
        <script type='text/javascript' src='<?= base_url('template/js/plugins/jquery/globalize.js') ?>'></script>    
        <script type='text/javascript' src='<?= base_url('template/js/plugins/bootstrap/bootstrap.min.js') ?>'></script>

        <script type='text/javascript' src='<?= base_url('template/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') ?>'></script>
        <script type='text/javascript' src='<?= base_url('template/js/plugins/uniform/jquery.uniform.min.js') ?>'></script>

        <script type='text/javascript' src='<?= base_url('template/js/plugins/knob/jquery.knob.js') ?>'></script>
        <script type='text/javascript' src='<?= base_url('template/js/plugins/sparkline/jquery.sparkline.min.js') ?>'></script>
        <script type='text/javascript' src='<?= base_url('template/js/plugins/flot/jquery.flot.js') ?>'></script>     
        <script type='text/javascript' src='<?= base_url('template/js/plugins/flot/jquery.flot.resize.js') ?>'></script>

        <script type='text/javascript' src='<?= base_url('template/js/plugins.js') ?>'></script>    
        <script type='text/javascript' src='<?= base_url('template/js/actions.js') ?>'></script>    
        <script type='text/javascript' src='<?= base_url('template/js/charts.js') ?>'></script>
        <script type='text/javascript' src='<?= base_url('template/js/settings.js') ?>'></script>
    </head>
    <body class="bg-img-num1"> 
        <div class="container">        
            <div class="login-block">
                <div class="block block-transparent login_form">
                    <div class="head head_login">
                        <?= translate('login')?>
                    </div>
                    <form method="post" action=<?= site_url("Login/auth") ?> >
                        <div class="content controls">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <span class="fa fa-envelope-o"></span>
                                        </div>
                                        <input required name="email" type="email" class="form-control" placeholder="<?= translate('email') ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <span class="fa fa-key"></span>
                                        </div>
                                        <input required name="password" type="password" class="form-control" placeholder="<?= translate('password') ?>"/>
                                    </div>
                                </div>
                            </div>                        
                            <div class="form-row">
                                <div class="col-md-6">
                                    <input type="submit" class="btn btn-primary btn-block btn-clean" value="Entrar"></input>
                                </div>
                                <div class="col-md-6">
                                    <input type="button" class="btn btn-primary btn-block btn-clean" value="Recuperar clave"></input>
                                </div>
                            </div>                      
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>