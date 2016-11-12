<ol class="breadcrumb">
	<li class=""><?php echo $this->Html->link('Dashboard', array('admin'=>true, 'controller'=>'admins', 'action'=>'dashboard')); ?></li> 
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
		</div>
		
		<div class="row">
			<div class="col-lg-12">
				
				<section class="panel"> 
					<div class="panel-body padding0">
						<div class="col-lg-6">	 
							<table class="table table-hover">
								<tbody>
								
									<div class="pageheader">
										<h2>Inventory</h2>
									</div>
								
									<tr>
										<td style="width: 100%;"><?php echo $this->Html->link('Inventory Details', array('controller' => 'purchases', 'action' => 'inventory_details'), array('style'=>'font-size:19px;', 'escape' => false)); ?></td> 
									</tr>
									 
						 
								</tbody>
							</table>
						</div>

						<div class="col-lg-6">	 
							<table class="table table-hover">
								<tbody>
								
									<div class="pageheader">
										<h2>Purchases</h2>
									</div>
								
									<tr>
										<td style="width: 100%;"><?php echo $this->Html->link('Purchase Order History', array('controller' => 'purchases', 'action' => 'purchase_order_history_report'), array('style'=>'font-size:19px;', 'escape' => false)); ?></td> 
									</tr>
									<tr>
										<td style="width: 100%;"><?php echo $this->Html->link('Purchase Receive Order History', array('controller' => 'purchases', 'action' => 'purchase_order_history_report_receive'), array('style'=>'font-size:19px;', 'escape' => false)); ?></td> 
									</tr>	 
						 
								</tbody>
							</table>
						</div>
						
						<div class="col-lg-6">	 
							<table class="table table-hover">
								<tbody>
								
									<div class="pageheader">
										<h2>Sales</h2>
									</div>
								
									<tr>
										<td style="width: 100%;"><?php echo $this->Html->link('Invoice History', array('controller' => 'invoices', 'action' => 'invoices_report'), array('style'=>'font-size:19px;', 'escape' => false)); ?></td> 
									</tr>	 
									
									<tr>
										<td style="width: 100%;"><?php echo $this->Html->link('Product Sales Report', array('controller' => 'sales', 'action' => 'sales_order_history_report'), array('style'=>'font-size:19px;', 'escape' => false)); ?></td> 
									</tr>	 
									
						 
								</tbody>
							</table>
						</div>
						 
						<?php /*<div class="col-lg-6">	 
							<table class="table table-hover">
								<tbody>
								
									<div class="pageheader">
										<h2>Activity</h2>
									</div>
								
									<tr>
										<td style="width: 100%;"><?php echo $this->Html->link('System Mails', array('controller' => 'purchases', 'action' => 'report'), array('style'=>'font-size:19px;', 'escape' => false)); ?></td> 
									</tr>								
									<tr>
										<td style="width: 100%;"><?php echo $this->Html->link('Activity Logs', array('controller' => 'purchases', 'action' => 'report'), array('style'=>'font-size:19px;', 'escape' => false)); ?></td> 
									</tr>
									
						 
								</tbody>
							</table>
						</div>
						 */ ?>
				 
						
						
						 
						
						
					</div> 
				</section>
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
	</div>
</div>