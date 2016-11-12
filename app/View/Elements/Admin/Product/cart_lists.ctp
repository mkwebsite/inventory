<?php if($data){  ?>

	<table class="dataTable table table-striped table-advance table-hover">
		<thead>
			<tr>
				<th>Title</th>
				<th>Selling Price</th>
				<th class="center">Quantity</th>
				<th class="center">Total</th>
				<th class="actionW"></th>
			</tr>
		</thead>
		
		<tbody><?php 
			$my_cart 		= $this->Session->read('MyCart'); //pr($my_cart);
			foreach($data as $value){
				$selected_qty	= (isset($my_cart['Products'][$value['Product']['id']]['quantity']) and $my_cart['Products'][$value['Product']['id']]['quantity'])?$my_cart['Products'][$value['Product']['id']]['quantity']:0;  
				$selling_price	= (isset($my_cart['Products'][$value['Product']['id']]['selling_price']) and $my_cart['Products'][$value['Product']['id']]['selling_price'])?$my_cart['Products'][$value['Product']['id']]['selling_price']:'0.00';   ?>
				
				<tr>
					<td><?php echo $this->Html->link($value['Product']['title'], array('controller'=>'products', 'action'=>'view', $value['Product']['id']), array('target'=>'_blank')); ?></td>
					<td class="hidden-phone">$<?php echo $value['Product']['selling_price']; ?></td>
					<td class="center"><?php echo $selected_qty; ?></td>
					<td class="center">$<?php echo $selling_price; ?></td>
					<td class="center"><?php 
						echo $this->Html->link('<i class="fa fa-times"></i> Remove', 'javascript:void(0);', array('onClick'=>'deleteFromCart('. $value['Product']['id'] .')', 'class'=>'btn btn-round btn-danger', 'escape'=>false)); ?>
					</td>
				</tr><?php
			} ?>
		</tbody>
		
		<tfoot>
			<tr>
				<td class="right bold" colspan="2">Total</td>
				<td class="center bold"><?php echo $this->Session->read('MyCart.total.quantity'); ?></td>
				<td class="center bold">$<?php echo $this->Session->read('MyCart.total.selling_price'); ?></td>
				<td>&nbsp;</td>
			</tr>
		</tfoot>
	</table><?php
	
}else{
	echo "<div class='no-record-found'>No Information for Display.</div>";
}