<?php
$role_id = isset($this->params['pass'][0])?$this->params['pass'][0]:2; ?>

<ol class="breadcrumb">
	<li><?php echo $this->Html->link('Dashboard', array('admin'=>true, 'controller'=>'admins', 'action'=>'dashboard')); ?></li>
	<li><?php echo $this->Html->link("Product Lists", array('admin'=>true, 'controller'=>'users', 'action'=>'index')); ?></li>
	<li><?php echo $this->Html->link($title_for_layout, "javascript:void(0);"); ?></li> 
</ol>
 

<div class="container-fluid">   
	<div data-widget-group="group1">   
	
		<div class="row">
			<div class="col-lg-12"> 
				<div class="left"><h3 class="page-title"><?php echo $title_for_layout; ?></h3></div>
				<div class="left position-relative" id='PageTitle' style='font-size: 20px; margin-top: 19px;'>&nbsp;<?php 
					echo $this->Html->link('<i class="fa fa-question-circle"></i>', "javascript:void(0)", array('escape'=>false)); ?>
				</div><div class="clear"></div>				
				<script>													
					var tooltipTimeout;					
					$("#PageTitle").hover(function(){
						tooltipTimeout = setTimeout(showTooltip_PageTitle, 2);
					},  hideTooltip_PageTitle);
					
					function showTooltip_PageTitle(){
						var tooltip = jQuery('<div id="tooltip_PageTitle" class="tooltip1">Please fill all the information in four tab and on error please check all tabs.</div>');
						tooltip.appendTo($("#PageTitle"));
					}

					function hideTooltip_PageTitle(){
						clearTimeout(tooltipTimeout);
						$("#tooltip_PageTitle").fadeOut().remove();
					}
				</script> 
			</div>
		</div><?php 

		echo $this->Form->create('Product', 
				array('type'=>'file', 'url'=>array('controller'=>'products', 'action'=>'add'),
					'inputDefaults' => array(
						'error' => array(
							'attributes' => array(
								'wrap' => 'span',
								'class' => 'danger'
							)
						)
					),
					'role'=>'form'
			)); 
			
			echo $this->Form->input('id'); ?>

			<div class="row">
				<div class="col-lg-12">
					<section class="panel panel-info">
						<header class="panel-heading tab-bg padding0">
							<ul class="nav nav-tabs nav-justified tabingcls">
								<li class="active">
									<a data-toggle="tab" href="#tab1">General Information</a>
								</li>
								
								<li class="">
									<a data-toggle="tab" href="#tab2">Sales Information</a>
								</li>
								
								<li class="">
									<a data-toggle="tab" href="#tab3">Purchase Information</a>
								</li>
							
								<li class="">
									<a data-toggle="tab" href="#tab4">Track Inventory for this Product</a>
								</li>
							</ul>
						</header>

					
						<div class="panel-body">
						 
							<div class="tab-content tasi-tab">
								<div id="tab1" class="tab-pane padding0 active"><?php 
									echo $this->element('Admin/Product/form'); ?>
								</div>
								
								<div id="tab2" class="tab-pane padding0"><?php 
									echo $this->element('Admin/Product/sales_info'); ?>
								</div>
								
								<div id="tab3" class="tab-pane padding0"><?php 
									echo $this->element('Admin/Product/purchase_info'); ?>
								</div>
							
								<div id="tab4" class="tab-pane padding0"><?php 
									echo $this->element('Admin/Product/track_inventory'); ?>
								</div> 
							</div>

							<div class="row">
								<div class="col-lg-12"><?php
									echo $this->Html->link("<i class='fa fa-caret-square-o-left'></i> Back", array('admin'=>true, 'controller'=>'products', 'action'=>'index'), array("class"=>"btn btn-default", "escape"=>false)) ."&nbsp;&nbsp;";   ?> 
									<button type="submit" class="btn btn-default"><i class='fa fa-check-square'></i> Add New Product</button>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div><?php

		echo $this->Form->end(); ?>
	</div>
</div>