<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->

	<head>			
		<?php echo $this->Html->charset(); ?>
		
		<title>  <?php echo $title_for_layout;?> |  <?php echo ($this->Session->check('SiteValue.site_name'))?$this->Session->read('SiteValue.site_name'):Configure::read('Site.title');?> </title>
		
		
		<script type="text/javascript">
			var SiteUrl = "<?php echo Configure::read('App.SiteUrl');?>";
			var SiteName = "<?php echo Configure::read('SITE_NAME');?>"; 		
		</script>
		
		<?php	
			if(isset($description_for_layout)){
				echo $this->Html->meta('description', $description_for_layout);
			}
			
			if(isset($keywords_for_layout)){
				echo $this->Html->meta('keywords', $keywords_for_layout);	
			}
			
			echo $this->Html->css(array(
				'bootstrap.min',
				'bootstrap-reset',
				'/assets/font-awesome/css/font-awesome',
				'owl.carousel',
				'/assets/advanced-datatable/media/css/demo_page',
				'/assets/advanced-datatable/media/css/demo_table',
				'/assets/data-tables/DT_bootstrap',
				'/assets/bootstrap-datepicker/css/datepicker',
				'slidebars',
				'style',
				'style-responsive',
				'jquery-ui-1.8.2.custom'
			));
			
			
			echo $this->Html->script(array('jquery', 'jquery-ui'));
		?>

		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
		<!--[if lt IE 9]>
		  <script src="<?php echo Configure::read('App.SiteUrl');?>/js/html5shiv.js"></script>
		  <script src="<?php echo Configure::read('App.SiteUrl');?>/js/respond.min.js"></script>
		<![endif]-->
		
		<link rel="shortcut icon" href="<?php echo Configure::read('App.SiteUrl');?>/img/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?php echo Configure::read('App.SiteUrl');?>/img/favicon.ico" type="image/x-icon">
	</head>

	<body>
		
		<section id="container" >
		
			<?php	echo $this->element('Admin/header'); ?>
			
			
			
			<?php	echo $this->element('Admin/navigation'); ?>
		

			<!--main content start-->		
			<section id="main-content">
				<section class="wrapper site-min-height">
				
					<?php $this->Layout->sessionFlash(); ?>
		  
					<?php echo $content_for_layout;?>
             
				</section>
			</section>
			<!--main content end-->
		
		
			<!--footer start-->
			<footer class="site-footer">
				<div class="text-center">
					2016 &copy; <?php echo $this->Session->read('SiteValue.site_name'); ?>.
					<a href="#" class="go-top">
						<i class="fa fa-angle-up"></i>
					</a>
				</div>
			</footer>
			<!--footer end-->
		</section><?php	


		echo $this->Html->script(array(
			'bootstrap.min', 
			'jquery.dcjqaccordion.2.7', 
			'jquery.scrollTo.min', 
			'jquery.nicescroll', 
			'jquery.sparkline', 
			'owl.carousel',
			'/assets/advanced-datatable/media/js/jquery.dataTables',
			'/assets/bootstrap-datepicker/js/bootstrap-datepicker',
			'/assets/data-tables/DT_bootstrap',
			'respond.min', 
			'modernizr.custom',
			'/assets/ckeditor/ckeditor',
			'slidebars.min', 
			'common-scripts',
		));	
		echo $scripts_for_layout; ?>
		
	</body>
</html>