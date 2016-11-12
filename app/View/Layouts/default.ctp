<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $title_for_layout; ?> |  <?php echo ($this->Session->check('SiteValue.site_name')) ? $this->Session->read('SiteValue.site_name') : Configure::read('Site.title'); ?></title>
        <link type='text/css' href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600' rel='stylesheet'>

		<?php
        if (isset($description_for_layout)) {
            echo $this->Html->meta('description', $description_for_layout);
        }
        if (isset($keywords_for_layout)) {
            echo $this->Html->meta('keywords', $keywords_for_layout);
        }
        echo $this->Html->meta('icon');
        echo $this->Html->css(array(
            '../assets/fonts/font-awesome/css/font-awesome.min',
            '../assets/fonts/themify-icons/themify-icons',
            '../assets/css/styles',
            '../assets/plugins/codeprettifier/prettify',
            '../assets/plugins/iCheck/skins/minimal/blue',
            '../assets/plugins/fullcalendar/fullcalendar',
            '../assets/plugins/switchery/switchery',
			'jquery-ui-1.8.2.custom',
        ));

        echo $this->Html->script(array(
            'modernizr-2.8.3-respond-1.4.2.min',
            'jquery.min'
        ));
        echo $scripts_for_layout;
        ?>

    </head>

    <body class="animated-content"> 
      <?php	echo $this->element('Admin/header'); ?>
    </li>

    <div id="wrapper">
        <div id="layout-static">
           
			<?php echo $this->element('Admin/navigation'); ?>
		   
            <div class="static-content-wrapper">
                <div class="static-content">
					<div class="page-content">  
						<?php $this->Layout->sessionFlash(); ?> 
						<?php echo $content_for_layout;?> 
                  
					</div>
                </div>
                <footer role="contentinfo">
                    <div class="clearfix">
                        <ul class="list-unstyled list-inline pull-left">
                            <li><h6 style="margin: 0;">&copy; 2015 Avenxo</h6></li>
                        </ul>
                        <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
                    </div>
                </footer>

            </div>
        </div>
    </div> 
    
    <!-- /Switcher -->
    <!-- Load site level scripts -->
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
        '../jquery.sparklines.min',
        '../assets/plugins/switchery/switchery',
        '../assets/plugins/easypiechart/jquery.easypiechart',
        '../assets/plugins/fullcalendar/moment.min',
        '../assets/plugins/fullcalendar/fullcalendar.min',
        '../assets/demo/demo-index',
    ));

    echo $scripts_for_layout;
    ?>	

</body>
</html>