<!DOCTYPE html>
<html lang='en'>
<head>        
    <title>Taurus</title>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <link rel='icon' type='image/ico' href='<?=base_url('template/favicon.ico')?>'/>
    <link href='<?=base_url('template/css/stylesheets.css')?>' rel='stylesheet' type='text/css' />        
    <script type='text/javascript' src='<?=base_url('template/js/plugins/bootstrap/bootstrap.min.js')?>'></script>

</head>
<body class='bg-default bg-light'>
    <div class='container'>        
        <div class='block-error'>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='error-logo'><img src='<?=base_url('template/img/logob.png')?>'/></div>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='error-code'>
                        <?=translate('error_404')?>
                    </div>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-12'>            
                    <div class='error-text'><?=translate('search_page_not_found')?></div>
                </div>
            </div>
            <div class='row'>
            	<div class='col-md-3'></div>
                <div class='col-md-6'>
                    <button class='btn btn-default btn-clean btn-block' onClick='history.back();'><?=translate('last_page')?></button>
                </div>
            </div>
        </div> 
    </div>
</body>
</html>