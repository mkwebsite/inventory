<?php $i = (isset($i) and $i)?$i:1; 
$productList = array();
$action = isset($this->params['action']) ? $this->params['action'] : '';
if($action=='admin_edit') {	
	$productList = $this->General->getPurchasesList($this->request->data['Purchase']['id']);	
} 
if(!empty($productList)) { 
	
	foreach($productList as $key=>$product_val) { ?> 

		<tr id="tr_<?php echo $key; ?>">
			<td><?php 
				$product_name = $product_val['Product']['sku'] .': '. $product_val['Product']['name']; 
				echo $this->Form->input('product_id', array('value'=>$product_val['PurchaseProduct']['product_id'], 'type'=>'hidden', 'id'=>'SaleProductId_'. $key, 'name'=>'data[Purchase][p]['. $key .'][product_id]')); 
				echo $this->Form->input('product', array('value'=>$product_name, 'id'=>'SaleProduct_'. $key, 'name'=>'data[Purchase][p]['. $key .'][product]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap", 'type'=>'textarea', 'rows'=>2)); ?>
			</td>
			<td><?php echo $this->Form->input('quantity', array('value'=>$product_val['PurchaseProduct']['qty'], 'id'=>'SaleQuantity_'. $key, 'type'=>'number', 'min'=>0, 'name'=>'data[Purchase][p]['. $key .'][quantity]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?></td>
			<td><?php echo $this->Form->input('rate', array('value'=>$product_val['PurchaseProduct']['rate'], 'id'=>'SaleRate_'. $key, 'type'=>'number', 'min'=>0, 'name'=>'data[Purchase][p]['. $key .'][rate]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?></td>
			<td><?php echo $this->Form->input('discount', array('value'=>$product_val['PurchaseProduct']['discount'], 'id'=>'SaleDiscount_'. $key, 'type'=>'number', 'min'=>0, 'name'=>'data[Purchase][p]['. $key .'][discount]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?></td>
			<td><?php echo $this->Form->input('tax', array('value'=>$product_val['PurchaseProduct']['tax'], 'id'=>'SaleTax_'. $key, 'type'=>'number', 'min'=>0, 'name'=>'data[Purchase][p]['. $key .'][tax]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?></td>
			<td><?php echo $this->Form->input('amount', array('value'=>$product_val['PurchaseProduct']['total_amount'], 'id'=>'SaleAmount_'. $key, 'type'=>'number', 'min'=>0, 'name'=>'data[Purchase][p]['. $key .'][amount]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?></td>
			<td style="text-align:center;"><?php
				echo $this->Html->link("<i class='fa fa-trash-o'></i>", "javascript:void(0);", array("onClick"=>"deleteRow(". $key .")", "escape"=>false, "class"=>"btn btn-default")); ?>
			</td>
		</tr>

		<script type="text/javascript">
			jQuery(document).ready(function(){	
				jQuery('#SaleProduct_<?php echo $key; ?>').autocomplete({
					source:"<?php echo Router::url(array('controller'=>'purchases', 'action'=>'product_info'), true);?>", 
					minLength:1,
					select:function(evt, ui){ //alert(ui.item.user_id);
						this.form.SaleProductId_<?php echo $key; ?>.value	= ui.item.product_id;
						this.form.SaleQuantity_<?php echo $key; ?>.value	= 1;
						this.form.SaleRate_<?php echo $key; ?>.value		= ui.item.rate;
						this.form.SaleDiscount_<?php echo $key; ?>.value	= 0;
						this.form.SaleTax_<?php echo $key; ?>.value		= ui.item.tax;
						this.form.SaleAmount_<?php echo $key; ?>.value	= ui.item.amount; 
					}
				});
			});
		</script><?php
	}

} else { ?>

	<tr id="tr_<?php echo $i; ?>">
		<td><?php 
			echo $this->Form->input('product_id', array('type'=>'hidden',  'id'=>'SaleProductId_'. $i, 'name'=>'data[Purchase][p]['. $i .'][product_id]')); 
			echo $this->Form->input('product', array('id'=>'SaleProduct_'. $i, 'onkeypress'=>"autocompleteProduct(".$i.")", 'name'=>'data[Purchase][p]['. $i .'][product]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap", 'type'=>'textarea', 'rows'=>2)); ?>
		</td>
		<td><?php echo $this->Form->input('quantity', array('id'=>'SaleQuantity_'. $i, 'type'=>'number', 'min'=>0, 'name'=>'data[Purchase][p]['. $i .'][quantity]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?></td>
		<td><?php echo $this->Form->input('rate', array('id'=>'SaleRate_'. $i, 'type'=>'number', 'min'=>0, 'name'=>'data[Purchase][p]['. $i .'][rate]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?></td>
		<td><?php echo $this->Form->input('discount', array('id'=>'SaleDiscount_'. $i, 'type'=>'number', 'min'=>0, 'name'=>'data[Purchase][p]['. $i .'][discount]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?></td>
		<td><?php echo $this->Form->input('tax', array('id'=>'SaleTax_'. $i, 'type'=>'number', 'min'=>0, 'name'=>'data[Purchase][p]['. $i .'][tax]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?></td>
		<td><?php echo $this->Form->input('amount', array('id'=>'SaleAmount_'. $i, 'type'=>'number', 'min'=>0, 'name'=>'data[Purchase][p]['. $i .'][amount]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?></td>
		<td style="text-align:center;"><?php
			echo $this->Html->link("<i class='fa fa-trash-o'></i>", "javascript:void(0);", array("onClick"=>"deleteRow(". $i .")", "escape"=>false, "class"=>"btn btn-default")); ?>
		</td>
	</tr>

	<script type="text/javascript">
		function autocompleteProduct(id) {
			 
			jQuery('#SaleProduct_'+id).autocomplete({
				source:"<?php echo Router::url(array('controller'=>'sales', 'action'=>'product_info'), true);?>", 
				minLength:1,
				select:function(evt, ui){ //alert(ui.item.user_id);
					this.form.SaleProductId_<?php echo $i; ?>.value	= ui.item.product_id;
					this.form.SaleQuantity_<?php echo $i; ?>.value	= 1;
					this.form.SaleRate_<?php echo $i; ?>.value		= ui.item.rate;
					this.form.SaleDiscount_<?php echo $i; ?>.value	= 0;
					this.form.SaleTax_<?php echo $i; ?>.value		= ui.item.tax;
					this.form.SaleAmount_<?php echo $i; ?>.value	= ui.item.amount; 
				}
			});
		}
	</script><?php  
} ?>