<div class="static-sidebar-wrapper sidebar-cyan">
	<div class="static-sidebar">
		<div class="sidebar">
			<?php
				$controller = isset($this->params['controller']) ? $this->params['controller'] : '';
				$action = isset($this->params['action']) ? $this->params['action'] : '';
				$role_id = (isset($this->params['pass'][0])) ? $this->params['pass'][0] : 2;
				?> 
			<div class="widget stay-on-collapse" id="widget-sidebar">
				<nav role="navigation" class="widget-body">
					<ul class="acc-menu"> 
						<li>
							<?php $class = (in_array($action, array('admin_dashboard'))) ? 'active' : ''; ?> 
							<?php echo $this->Html->link('<i class="ti ti-home"></i>Dashboard', array('controller' => 'admins', 'action' => 'dashboard'), array('escape' => false)); ?>
						 </li><?php
						
						$class = ($role_id == 2 && $controller == 'users' && in_array($action, array('admin_index', 'admin_edit', 'admin_view', 'admin_add'))) ? 'open active' : null; ?>
						<li class="<?php echo $class; ?>"> 
							<a href="javascript:;"><i class="ti ti-user"></i><span>Customer Lists</span></a>
							<ul class="acc-menu active" style="<?php echo ($class)?'display: block;':''; ?>"> 
								<li><?php echo $this->Html->link('Customer Lists', array('controller' => 'users', 'action' => 'index', 2), array('escape' => false)); ?></li>
								<li><?php echo $this->Html->link('Add Customer', array('controller' => 'users', 'action' => 'add', 2), array('escape' => false)); ?></li>
							 </ul>
						</li><?php
						
						$class = ($role_id == 3 && $controller == 'users' && in_array($action, array('admin_index', 'admin_edit', 'admin_view', 'admin_add'))) ? 'open active' : null; ?>
						<li class="<?php echo $class; ?>"> 
							<a href="javascript:;"><i class="ti ti-user"></i><span>Vendor Lists</span></a>
							<ul class="acc-menu active" style="<?php echo ($class)?'display: block;':''; ?>"> 
								<li><?php echo $this->Html->link('Vendor Lists', array('controller' => 'users', 'action' => 'index', 3), array('escape' => false)); ?></li>
								<li><?php echo $this->Html->link('Add Vendor', array('controller' => 'users', 'action' => 'add', 3), array('escape' => false)); ?></li>
							 </ul>
						</li><?php
						
						$class = ($controller == 'products' && in_array($action, array('admin_index', 'admin_edit', 'admin_view', 'admin_add'))) ? 'open active' : null; ?>
						<li class="<?php echo $class; ?>"> 
							<a href="javascript:;"><i class="fa fa-ruble"></i><span>Product Lists</span></a>
							<ul class="acc-menu active" style="<?php echo ($class)?'display: block;':''; ?>"> 
								<li><?php echo $this->Html->link('Product Lists', array('controller' => 'products', 'action' => 'index'), array('escape' => false)); ?></li>
								<li><?php echo $this->Html->link('Add Product', array('controller' => 'products', 'action' => 'add'), array('escape' => false)); ?></li>
							 </ul>
						</li><?php
						
						$class = ($controller == 'sales' && in_array($action, array('admin_index', 'admin_edit', 'admin_view', 'admin_add'))) ? 'open active' : null; ?>
						<li class="<?php echo $class; ?>"> 
							<a href="javascript:;"><i class="fa fa-shopping-cart"></i><span>Sales Order</span></a>
							<ul class="acc-menu active" style="<?php echo ($class)?'display: block;':''; ?>"> 
								<li><?php echo $this->Html->link('Sales Order', array('controller' => 'sales', 'action' => 'index'), array('escape' => false)); ?></li>
								<li><?php echo $this->Html->link('Add Sales Order', array('controller' => 'sales', 'action' => 'add'), array('escape' => false)); ?></li>
							 </ul>
						</li><?php
						
						$class = ($controller == 'purchases' && in_array($action, array('admin_index', 'admin_edit', 'admin_view', 'admin_add'))) ? 'open active' : null; ?>
						<li class="<?php echo $class; ?>"> 
							<a href="javascript:;"><i class="fa fa-shopping-cart"></i><span>Purchase Order</span></a>
							<ul class="acc-menu active" style="<?php echo ($class)?'display: block;':''; ?>"> 
								<li><?php echo $this->Html->link('Purchases Order', array('controller' => 'purchases', 'action' => 'index'), array('escape' => false)); ?></li>
								<li><?php echo $this->Html->link('Add Purchase Order', array('controller' => 'purchases', 'action' => 'add'), array('escape' => false)); ?></li>
							 </ul>
						</li><?php
						
						$class = (($controller == 'purchases' || $controller == 'sales' || $controller == 'invoices') && in_array($action, array('admin_invoices_report', 'admin_report', 'admin_purchase_order_history_report', 'admin_sales_order_history_report'))) ? 'open active' : null; ?>
						<li class="<?php echo $class; ?>"> 
							<?php echo $this->Html->link('<i class="fa fa-flag-o"></i>Reports', array('controller' => 'purchases', 'action' => 'report'), array('escape' => false)); ?>
					 	</li><?php
						
						$class = ($controller == 'purchases' && in_array($action, array('admin_index', 'admin_edit', 'admin_view', 'admin_add'))) ? 'open active' : null; ?>
						<li class="<?php echo $class; ?>"> 
							<a href="javascript:;"><i class="fa fa-envelope"></i><span>Invoices</span></a>
							<ul class="acc-menu active" style="<?php echo ($class)?'display: block;':''; ?>"> 
								<li><?php echo $this->Html->link('Invoice List', array('controller' => 'invoices', 'action' => 'index'), array('escape' => false)); ?></li>
								<li><?php echo $this->Html->link('Add Invoice', array('controller' => 'invoices', 'action' => 'add'), array('escape' => false)); ?></li>
							 </ul>
						</li>

				  </ul>
				</nav>
			</div>

			 
		</div>
	</div>
</div>