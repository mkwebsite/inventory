<?php  
echo $this->Html->css(array(
		'bootstrap.min', 
		'font-awesome.min',   
		'AdminLTE.min',  
		'main-pdf' 
	)); ?>

<div class="box-body table-responsive"> 
	<table class="table table-bordered table-striped">
		<thead> 
			<tr>
				<th style="width:12%; height: 37px;" class="text-center">Status</th>
				<th style="width:24%;" class="text-center">Invoice Date</th>
				<th style="width:12%;" class="text-center">Due Date</th>
				<th style="width:15%;" class="text-center">Invoice#</th>
				<th style="width:10%;" class="text-center">P.O.#</th>
				<th style="width:15%;" class="text-center">Customer Name</th>
				<th style="width:15%;" class="text-center">Invoice Amount</th> 
			</tr>
		</thead>
		<tbody><?php  
			if(!empty($posts)) { 
				foreach($posts as $key => $post_val) { ?>	 
					<tr> 
						<td class="text-center"><?php echo isset($post_val['Post']['status'])?$post_val['Post']['status']:''; ?>&nbsp;</td> 
						<td class="text-center"><?php echo isset($post_val['Post']['invoice_date'])?$post_val['Post']['invoice_date']:''; ?>&nbsp;</td> 
						<td class="text-center"><?php echo isset($post_val['Post']['due_date'])?$post_val['Post']['due_date']:''; ?>&nbsp;</td> 
						<td class="text-center"><?php echo isset($post_val['Post']['invoice_number'])?$post_val['Post']['invoice_number']:''; ?>&nbsp;</td> 
						<td class="text-center"><?php echo isset($post_val['Post']['order_number'])?$post_val['Post']['order_number']:''; ?>&nbsp;</td> 
						<td class="text-center"><?php echo isset($post_val['Post']['customer_name'])?$post_val['Post']['customer_name']:''; ?>&nbsp;</td> 
						<td class="text-center"><?php echo isset($post_val['Post']['invoice_amount'])?$post_val['Post']['invoice_amount']:''; ?>&nbsp;</td> 
					</tr><?php 
				} 
			}?>   
		</tbody>
	</table>  
</div>