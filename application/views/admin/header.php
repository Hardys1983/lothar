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
                                MENU <span class="fa fa-chevron-down"></span>
                                <span class="icon-reorder"></span>                            
                            </button>                                                
                            <a class="navbar-brand" href="<?= site_url("Welcome/index") ?>"><img src='<?= base_url('template/img/logoa.svg') ?>'/></a>                                                                                     
                        </div>
                        <div class="collapse navbar-collapse navbar-ex1-collapse">                                     
                            <ul class="nav navbar-nav">
                                <!--                                <li class="active">
                                                                    <a href="<?= site_url("Welcome/index") ?>">
                                                                        <span class="icon-home"></span> dashboard
                                                                    </a>
                                                                </li>  -->
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-sign-in"></span> <?= translate('vehicular_reception') ?></a>
                                    <ul class="dropdown-menu">                                  
                                        <li><a href="<?= site_url('vehicular_reception/new_work_order') ?>"><?= translate('new_order') ?></a></li>
                                        <li><a href="<?= site_url('vehicular_reception/index') ?>"><?= translate('work_orders') ?></a></li>
                                    </ul>                                
                                </li>                          
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-pencil"></span> <?= translate('contents') ?></a>
                                    <ul class="dropdown-menu">                                    
                                        <li><a href="<?= site_url('News/news') ?>"><?= translate('news') ?></a></li>
                                        <li><a href="<?= site_url('Promotion/promotion') ?>"><?= translate('promotions') ?></a></li>
                                        <li><a href="<?= site_url('Service/service') ?>"><?= translate('services') ?></a></li>
                                        <li><a href="<?= site_url('Banner/banner') ?>"><?= translate('banners') ?></a></li>
                                    </ul>                                
                                </li>
                                <li><a href="<?= site_url('User/index') ?>"><span class="fa fa-users"></span><?= translate('users') ?></a></li>
                                <li><a href="<?= site_url('Vehicle/index') ?>"><span class="fa fa-car"></span><?= translate('vehicles') ?></a></li>
                                <li><a href="<?= site_url('Owner/index') ?>"><span class="fa fa-key"></span><?= translate('owners') ?></a></li>
                                <li><a href="<?= site_url('Appointment/appointments') ?>"><span class="fa fa-check-square-o"></span> <?= translate('appointments') ?></a></li>
                                <li><a href="<?= site_url('Login/logout') ?>"><span class="fa fa-sign-out"></span> Logout</a></li>
                                <!--                                <li class="dropdown">
                                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-cogs"></span> components</a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a href="component_blocks.html">Blocks and panels</a></li>
                                                                        <li><a href="component_buttons.html">Buttons</a></li>
                                                                        <li><a href="component_modals.html">Modals and popups</a></li>                                    
                                                                        <li><a href="component_tabs.html">Tabs, accordion, selectable, sortable</a></li>
                                                                        <li><a href="component_progress.html">Progressbars</a></li>
                                                                        <li><a href="component_lists.html">List groups</a></li>
                                                                        <li><a href="component_messages.html">Messages</a></li>                                    
                                                                        <li>
                                                                            <a href="#">Tables<i class="icon-angle-right pull-right"></i></a>
                                                                            <ul class="dropdown-submenu">
                                                                                <li><a href="component_table_default.html">Default tables</a></li>
                                                                                <li><a href="component_table_sortable.html">Sortable tables</a></li>                                            
                                                                            </ul>
                                                                        </li>                                                                        
                                                                        <li>
                                                                            <a href="#">Layouts<i class="icon-angle-right pull-right"></i></a>
                                                                            <ul class="dropdown-submenu">
                                                                                <li><a href="component_layout_blank.html">Default layout(blank)</a></li>
                                                                                <li><a href="component_layout_custom.html">Custom navigation</a></li>
                                                                                <li><a href="component_layout_scroll.html">Content scroll</a></li>
                                                                                <li><a href="component_layout_fixed.html">Fixed content</a></li>
                                                                                <li><a href="component_layout_white.html">White layout</a></li>
                                                                            </ul>
                                                                        </li>
                                                                        <li><a href="component_charts.html">Charts</a></li>
                                                                        <li><a href="component_maps.html">Maps</a></li>
                                                                        <li><a href="component_typography.html">Typography</a></li>
                                                                        <li><a href="component_gallery.html">Gallery</a></li>
                                                                        <li><a href="component_calendar.html">Calendar</a></li>
                                                                        <li><a href="component_icons.html">Icons</a></li>                                    
                                                                    </ul>
                                                                </li>
                                
                                                                <li class="dropdown">
                                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-file-alt"></span> pages</a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a href="sample_login.html">Login</a></li>
                                                                        <li><a href="sample_registration.html">Registration</a></li>
                                                                        <li><a href="sample_profile.html">User profile</a></li>
                                                                        <li><a href="sample_profile_social.html">Social profile</a></li>
                                                                        <li><a href="sample_edit_profile.html">Edit profile</a></li>
                                                                        <li><a href="sample_mail.html">Mail</a></li>
                                                                        <li><a href="sample_search.html">Search</a></li>
                                                                        <li><a href="sample_invoice.html">Invoice</a></li>
                                                                        <li><a href="sample_contacts.html">Contacts</a></li>
                                                                        <li><a href="sample_tasks.html">Tasks</a></li>
                                                                        <li><a href="sample_timeline.html">Timeline</a></li>
                                                                        <li>
                                                                            <a href="#">Email templates<i class="icon-angle-right pull-right"></i></a>
                                                                            <ul class="dropdown-submenu">
                                                                                <li><a href="email_sample_1.html">Sample 1</a></li>
                                                                                <li><a href="email_sample_2.html">Sample 2</a></li>
                                                                                <li><a href="email_sample_3.html">Sample 3</a></li>
                                                                                <li><a href="email_sample_4.html">Sample 4</a></li>
                                                                            </ul>
                                                                        </li>                                    
                                                                        <li>
                                                                            <a href="#">Error pages<i class="icon-angle-right pull-right"></i></a>
                                                                            <ul class="dropdown-submenu">
                                                                                <li><a href="sample_error_403.html">403 Forbidden</a></li>
                                                                                <li><a href="sample_error_404.html">404 Not Found</a></li>
                                                                                <li><a href="sample_error_500.html">500 Internal Server Error</a></li>
                                                                                <li><a href="sample_error_503.html">503 Service Unavailable</a></li>
                                                                                <li><a href="sample_error_504.html">504 Gateway Timeout</a></li>                                                                                       
                                                                            </ul>
                                                                        </li>                                    
                                                                    </ul>
                                                                </li>                            -->
                            </ul>
                            <!--                            <form class="navbar-form navbar-right" role="search">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" placeholder="search..."/>
                                                            </div>                            
                                                        </form>                                            -->
                        </div>
                    </nav>          
                </div>      
            </div>
        </div>
        <br><br><br>
        <div class="container">        
