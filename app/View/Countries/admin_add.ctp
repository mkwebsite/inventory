<div class="row">
	<div class="col-lg-12"><?php
		echo $this->Html->link('Dashboard', array('admin'=>true, 'controller'=>'admins', 'action'=>'dashboard')) ."&nbsp;&nbsp;/&nbsp;&nbsp;";
		echo $this->Html->link("Country Lists", array('admin'=>true, 'controller'=>'countries', 'action'=>'index')) ."&nbsp;&nbsp;/&nbsp;&nbsp;"; 
		echo $this->Html->link($title_for_layout, "javascript:void(0);"); ?>
	</div> 
</div>

<div class="row">
	<div class="col-lg-12">
		<h3 class="page-title"><?php
			echo $title_for_layout; ?>
		</h3>
	</div>
</div><?php 

echo $this->Form->create('Country', 
		array('type' => 'file', 'url' => array('controller' => 'countries', 'action' => 'add'),
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
				<header class="panel-heading">Basic Informations </header>
			
				<div class="panel-body"><?php 
				
					echo $this->element('Admin/Country/form'); ?>

					<div class="row">
						<div class="col-lg-12"><?php
							echo $this->Html->link("<i class='fa fa-caret-square-o-left'></i> Back", array('admin'=>true, 'controller'=>'countries', 'action'=>'index'), array("class"=>"btn btn-primary", "escape"=>false)) ."&nbsp;&nbsp;";   ?> 
							<button type="submit" class="btn btn-primary"><i class='fa fa-check-square'></i> Add New Country </button>
						</div>
					</div>
					
				</div>
				
			</section>
		</div>
	</div><?php

echo $this->Form->end(); ?>