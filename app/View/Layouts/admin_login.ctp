<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $title_for_layout; ?> |  <?php echo ($this->Session->check('SiteValue.site_name')) ? $this->Session->read('SiteValue.site_name') : Configure::read('Site.title'); ?></title> 

        <?php
        if (isset($description_for_layout)) {
            echo $this->Html->meta('description', $description_for_layout);
        }
        if (isset($keywords_for_layout)) {
            echo $this->Html->meta('keywords', $keywords_for_layout);
        }
        echo $this->Html->meta('icon');
        echo $this->Html->css(array(
            '../assets/plugins/iCheck/skins/minimal/blue',
            '../assets/fonts/font-awesome/css/font-awesome.min',
            '../assets/fonts/themify-icons/themify-icons',
            '../assets/css/styles.css',
        ));
        ?>
 
        <link rel="shortcut icon" href="img/favicon.ico"></link>

    </head>

    <body class="focused-form animated-content">


        <div class="container" id="login-form">
            <a href="index.html" class="login-logo">
<!-- <img src="assets/img/logo-big.png"> -->
<h1><b>inventory management</b></h1>
</a>
            
             <?php echo $content_for_layout; ?>
            
            
            
        </div>


        <?php
        echo $this->Html->script(array(
            '../assets/js/jquery-1.10.2.min',
            '../assets/js/jqueryui-1.10.3.min',
            '../assets/js/bootstrap.min',
             '../assets/js/enquire.min',
             '../assets/plugins/velocityjs/velocity.min',
             '../assets/plugins/velocityjs/velocity.ui.min',
             '../assets/plugins/wijets/wijets',
             '../assets/plugins/codeprettifier/prettify',
             '../assets/plugins/bootstrap-switch/bootstrap-switch',
             '../assets/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop',
             '../assets/plugins/iCheck/icheck.min',
             '../assets/plugins/nanoScroller/js/jquery.nanoscroller.min',
             '../assets/js/application',
             '../assets/demo/demo',
             '../assets/demo/demo-switcher',
            
            
            
        ));
        ?> 				 
    </body> 


   

 

</html>