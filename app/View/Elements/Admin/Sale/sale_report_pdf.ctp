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
				<th style="width:12%; height: 37px;" class="text-center">Date</th>
				<th style="width:24%;" class="text-center">Sales Order#</th>
				<th style="width:12%;" class="text-center">Customer Name</th>
				<th style="width:15%;" class="text-center">Ref#</th>
				<th style="width:10%;" class="text-center">Shipment Date</th>
				<th style="width:15%;" class="text-center">Status</th>
				<th style="width:15%;" class="text-center">Amount</th> 
			</tr>
		</thead>
		<tbody><?php  
			if(!empty($posts)) { 
				foreach($posts as $key => $post_val) { ?>	 
					<tr> 
						<td class="text-center"><?php echo isset($post_val['Post']['date'])?$post_val['Post']['date']:''; ?>&nbsp;</td> 
						<td class="text-center"><?php echo isset($post_val['Post']['sale_order'])?$post_val['Post']['sale_order']:''; ?>&nbsp;</td> 
						<td class="text-center"><?php echo isset($post_val['Post']['customer_name'])?$post_val['Post']['customer_name']:''; ?>&nbsp;</td> 
						<td class="text-center"><?php echo isset($post_val['Post']['reference'])?$post_val['Post']['reference']:''; ?>&nbsp;</td> 
						<td class="text-center"><?php echo isset($post_val['Post']['shipment_data'])?$post_val['Post']['shipment_data']:''; ?>&nbsp;</td> 
						<td class="text-center"><?php echo isset($post_val['Post']['status'])?$post_val['Post']['status']:''; ?>&nbsp;</td> 
						<td class="text-center"><?php echo isset($post_val['Post']['amount'])?$post_val['Post']['amount']:''; ?>&nbsp;</td> 
					</tr><?php 
				} 
			}?>   
		</tbody>
	</table>  
</div>