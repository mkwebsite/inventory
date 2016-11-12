<div class="row">
	<div class="col-lg-12"><?php
		
		$controller = isset($this->params['controller'])?$this->params['controller']:'';
		$action		= isset($this->params['action'])?$this->params['action']:'';
	
		echo $this->Html->link('Clear Cart', "#CLR_CART", array('class'=>'btn btn-shadow btn-default', 'data-toggle'=>'modal', 'escape'=>false));
		//echo $this->Html->link('Clear Cart', array('admin'=>true, 'controller'=>'product_solds', 'action'=>'clear_cart'), array("class"=>"btn btn-shadow btn-danger")); ?>
		

		<div class="modal fade" id="CLR_CART" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 class="modal-title">Clear Cart Information!!</h3>
					</div>
					<div class="modal-body">Are you sure, you want to clear cart information?</div>
					<div class="modal-footer">
						<button data-dismiss="modal" class="btn btn-default" type="button">Close</button><?php
						echo $this->Html->link('Confirm', array('admin'=>true, 'controller'=>'product_solds', 'action'=>'clear_cart'), array('data-toggle'=>'modal', 'escape'=>false, 'class'=>'btn btn-warning')) ; ?>
					</div>
				</div>
			</div>
		</div><?php
		
		$class = ($action=='admin_generate_new')?'success':'default';
		echo $this->Html->link('Step1: Select a User', array('admin'=>true, 'controller'=>'product_solds', 'action'=>'generate_new'), array('data-toggle'=>'modal', 'escape'=>false, 'class'=>'btn btn-shadow btn-'. $class)) ."&nbsp;";
		
		$class = ($action=='admin_select_product')?'success':'default';
		echo $this->Html->link('Step2: Select Products', array('admin'=>true, 'controller'=>'product_solds', 'action'=>'select_product'), array('data-toggle'=>'modal', 'escape'=>false, 'class'=>'btn btn-shadow btn-'. $class)) ."&nbsp;";
		
		$class = ($action=='admin_cart')?'success':'default';
		echo $this->Html->link('Step3: Cart', array('admin'=>true, 'controller'=>'product_solds', 'action'=>'cart'), array('data-toggle'=>'modal', 'escape'=>false, 'class'=>'btn btn-shadow btn-'. $class)) ; ?>
		
	</div>
</div>