<?php
$role_id = isset($this->params['pass'][0])?$this->params['pass'][0]:2; ?>

<ol class="breadcrumb">
	<li><?php echo $this->Html->link('Dashboard', array('admin'=>true, 'controller'=>'admins', 'action'=>'dashboard')); ?></li>
	<li><?php echo $this->Html->link($lable ." Lists", array('admin'=>true, 'controller'=>'users', 'action'=>'index', $role_id)); ?></li>
	<li><?php echo $this->Html->link($title_for_layout, "javascript:void(0);"); ?></li> 
</ol>

<div class="container-fluid">   
	<div data-widget-group="group1">   

		<div class="row">
			<div class="col-lg-12">
				<h3 class="page-title"><?php
					echo $title_for_layout; ?>
				</h3>
			</div>
		</div><?php 

		echo $this->Form->create('User', 
				array('type' => 'file', 'url' => array('controller' => 'users', 'action' => 'add', $role_id),
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
									<a data-toggle="tab" href="#tab2">Social Information</a>
								</li>
								
								<li class="">
									<a data-toggle="tab" href="#tab3">Notes</a>
								</li><?php
								
								if($role_id == 2){ ?>
									<li class="">
										<a data-toggle="tab" href="#tab4">Shipping Address</a>
									</li>
									
									<li class="">
										<a data-toggle="tab" href="#tab5">Billing Address</a>
									</li><?php
								} ?>
							</ul>
						</header>

					
						<div class="panel-body">
						 
							<div class="tab-content tasi-tab">
								<div id="tab1" class="tab-pane padding0 active"><?php 
									echo $this->element('Admin/User/form'); ?>
								</div>
								
								<div id="tab2" class="tab-pane padding0"><?php 
									echo $this->element('Admin/User/social_information'); ?>
								</div>
								
								<div id="tab3" class="tab-pane padding0"><?php 
									echo $this->element('Admin/User/notes'); ?>
								</div><?php
								
								if($role_id == 2){ ?>
									<div id="tab4" class="tab-pane padding0"><?php 
										echo $this->element('Admin/User/shipping_address'); ?>
									</div>
									<div id="tab5" class="tab-pane padding0"><?php 
										echo $this->element('Admin/User/billing_address'); ?>
									</div><?php
								} ?>
							</div>

							<div class="row">
								<div class="col-lg-12"><?php
									echo $this->Html->link("<i class='fa fa-caret-square-o-left'></i> Back", array('admin'=>true, 'controller'=>'users', 'action'=>'index', $role_id), array("class"=>"btn btn-default", "escape"=>false)) ."&nbsp;&nbsp;";   ?> 
									<button type="submit" class="btn btn-default"><i class='fa fa-check-square'></i> Add new <?php echo $lable; ?></button>
								</div>
							</div>
							
						</div>
						
					</section>
				</div>
			</div><?php

		echo $this->Form->end(); ?>
	</div>
</div>