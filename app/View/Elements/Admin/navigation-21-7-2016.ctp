<div id="controls"> 
	<aside id="sidebar">
		<div id="sidebar-wrap">
			<div class="panel-group slim-scroll" role="tablist">
				<div class="panel panel-default">
					<div id="sidebarNav" class="panel-collapse collapse in" role="tabpanel">
						<div class="panel-body"><?php
							
							$controller = isset($this->params['controller'])?$this->params['controller']:'';
							$action		= isset($this->params['action'])?$this->params['action']:'';
							$role_id 	= (isset($this->params['pass'][0]))?$this->params['pass'][0]:2; ?>
						 
							<ul id="navigation"><?php
							
								$class = (in_array($action, array('admin_dashboard')))?'active':''; ?>
								<li class="<?php echo $class; ?>"><?php									
									echo $this->Html->link('<i class="fa fa-dashboard"></i>Dashboard', array('controller'=>'admins', 'action'=>'dashboard'), array('escape'=>false)); ?>
								</li><?php
								
								$class = ($role_id == 2 && $controller == 'users' && in_array($action, array('admin_index','admin_edit','admin_view','admin_add')))?'active':null; ?>
								<li class="<?php echo $class; ?>"><?php
									echo $this->Html->link('<i class="fa fa-users"></i> Customer Lists', array('controller'=>'users', 'action'=>'index', 2), array('escape'=>false)); ?>
								</li><?php
								
								$class = ($role_id == 3 && $controller == 'users' && in_array($action, array('admin_index','admin_edit','admin_view','admin_add')))?'active':null; ?>
								<li class="<?php echo $class; ?>"><?php
									echo $this->Html->link('<i class="fa fa-shopping-cart"></i> Vendor Lists', array('controller'=>'users', 'action'=>'index', 3), array('escape'=>false)); ?>
								</li><?php
								
								$class = ($controller == 'products' && in_array($action, array('admin_index','admin_edit','admin_view','admin_add')))?'active':null; ?>
								<li class="<?php echo $class; ?>"><?php
									echo $this->Html->link('<i class="fa fa-ruble"></i> Product Lists', array('controller'=>'products', 'action'=>'index'), array('escape'=>false)); ?>
								</li>
							</ul> 

						</div>
					</div>
				</div>
			</div>
		</div>
	</aside>
<!--/ SIDEBAR Content -->  

</div> 