<ol class="breadcrumb">
	<li class=""><?php echo $this->Html->link('Dashboard', array('admin'=>true, 'controller'=>'admins', 'action'=>'dashboard')); ?></li>
	<li class=""><?php echo $this->Html->link('Sales Order Lists', array('admin'=>true, 'controller'=>'sales', 'action'=>'index')); ?></li>
	<li class=""><?php echo $this->Html->link($title_for_layout, "javascript:void(0);"); ?></li>
</ol>

<div class="container-fluid">   
	<div data-widget-group="group1">   
		<div class="col-lg-12 p-n">
			<div class="col-lg-4 p-n">
				<div class="pageheader">
					<h2><?php echo $title_for_layout; ?></h2>
				</div>
			</div>
		</div><?php 

		echo $this->Form->create('Sale', 
				array('type'=>'file', 'url'=>array('controller'=>'sales', 'action'=>'add'),
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
					<section class="panel">
						<header class="panel-heading tab-bg padding0"></header>

						<div class="panel-body"><?php 
							echo $this->element('Admin/Sale/form'); ?>

							<div class="row">
								<div class="col-lg-12"><?php
									echo $this->Html->link("<i class='fa fa-caret-square-o-left'></i> Back", array('admin'=>true, 'controller'=>'sales', 'action'=>'index'), array("class"=>"btn btn-default", "escape"=>false)) ."&nbsp;&nbsp;";   ?> 
									<button type="submit" class="btn btn-default"><i class='fa fa-check-square'></i> Add New Sale</button>
								</div>
							</div> 
						</div>
					</section>
				</div>
			</div><?php

		echo $this->Form->end(); ?>
	</div>
</div>