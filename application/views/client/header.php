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
        <div class="row row_menu">  
            <div class="container">
                <div class="col-md-12">

                    <nav class="navbar brb" role="navigation">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-reorder"></span>                            
                            </button>                                                
                            <a class="navbar-brand" href="index.html"><img src='<?= base_url('template/img/logoa.svg') ?>'/></a>                                                                                     
                        </div>
                        <div class="collapse navbar-collapse navbar-ex1-collapse">                                     
                            <ul class="nav navbar-nav">
                                <li><a href="<?= site_url('Client/vehicles') ?>"><span class="fa fa-car"></span> <?= translate('vehicles') ?></a></li>
                                <li><a href="<?= site_url('Client/appointments') ?>"><span class="fa fa-list"></span> <?= translate('appointments') ?></a></li>
                                <li><a href="<?= site_url('Login/logout') ?>"><span class="fa fa-sign-out"></span> Logout</a></li>
                            </ul>

                        </div>
                    </nav>          
                </div>   
            </div>
        </div>   <br><br><br>
        <div class="container">        
