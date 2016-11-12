<div class="container-fluid">   
	<div data-widget-group="group1"> 

		<div class="pageheader">
			<h2><?php echo $title_for_layout; ?></h2>
		</div><?php 

		$id = isset($this->params['pass'][0])?$this->params['pass'][0]:'';
		echo $this->Form->create('User', 
				array('url' => array('controller' => 'admins', 'action' => 'change_password', $id),
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
						<header class="panel-heading"><h2>Enter your new password</h2></header>
						
						
						<div class="panel-body"><?php 

							echo $this->element('Admin/Admin/password'); ?>

							<div class="row">
								<div class="col-lg-12"><?php
									echo $this->Html->link("<i class='fa fa-dashboard'></i> Dashboard", array('admin'=>true, 'controller'=>'admins', 'action'=>'dashboard'), array("class"=>"btn btn-default", "escape"=>false)) ."&nbsp;&nbsp;";   ?> 
									<button type="submit" class="btn btn-default"><i class='fa fa-check-square'></i> Update</button>
								</div>
							</div>
							
						</div>
					</section>
				</div>
			</div><?php

		echo $this->Form->end(); ?>
	</div>
</div>