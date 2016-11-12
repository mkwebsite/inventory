<ol class="breadcrumb">
	<li><?php echo $this->Html->link('Home', array('admin'=>true, 'controller'=>'admins', 'action'=>'dashboard')); ?></li> 
	<li><?php echo $this->Html->link($title_for_layout, "javascript:void(0);"); ?></li> 
</ol>
 

<div class="container-fluid"> 

	<div class="row">
	
		<div class="col-md-3">
			<div class="info-tile tile-danger">
				<div class="tile-icon"><i class="fa fa-check-square-o"></i></div>
				<div class="tile-heading"><span>Quantity</span></div>
				<div class="tile-body"><span>0</span></div>
				<div class="tile-footer"><span class="text-success">Quantity to be Packed <i class="fa fa-check-square-o"></i></span></div>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="info-tile tile-danger">
				<div class="tile-icon"><i class="fa fa-truck"></i></div>
				<div class="tile-heading"><span>Packages</span></div>
				<div class="tile-body"><span>0</span></div>
				<div class="tile-footer"><span class="text-success"> Packages to be Shipped <i class="fa fa-truck"></i></span></div>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="info-tile tile-danger">
				<div class="tile-icon"><i class="fa fa-check-square-o"></i></div>
				<div class="tile-heading"><span>Packages</span></div>
				<div class="tile-body"><span>0</span></div>
				<div class="tile-footer"><span class="text-success"> Packages to be Delivered <i class="fa fa-ticket"></i></span></div>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="info-tile tile-danger">
				<div class="tile-icon"><i class="fa fa-file-text-o"></i></div>
				<div class="tile-heading"><span>Quantity</span></div>
				<div class="tile-body"><span>0</span></div>
				<div class="tile-footer"><span class="text-success">Quantity to be Invoiced <i class="fa fa-file-text-o"></i></span></div>
			</div>
		</div>
	
		 
	</div> 

</div> <!-- .container-fluid --> 