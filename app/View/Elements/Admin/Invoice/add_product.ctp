<?php $i = (isset($i) and $i)?$i:1; 
$productList = array();
$action = isset($this->params['action']) ? $this->params['action'] : '';
if($action=='admin_edit') {	
	$productList = $this->General->getInvoiceProduct($this->request->data['Invoice']['id']);	
} 
 

if(!empty($productList)) { 
	
	foreach($productList as $key=>$product_val) { ?> 

		<tr id="tr_<?php echo $key; ?>">
			<td><?php 
				$product_name = $product_val['Product']['sku'] .': '. $product_val['Product']['name']; 
				echo $this->Form->input('product_id', array('value'=>$product_val['InvoiceProduct']['product_id'], 'type'=>'hidden', 'id'=>'InvoiceProductId_'. $key, 'name'=>'data[Invoice][p]['. $key .'][product_id]')); 
				echo $this->Form->input('product', array('value'=>$product_name, 'id'=>'InvoiceProduct_'. $key, 'name'=>'data[Invoice][p]['. $key .'][product]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap", 'type'=>'textarea', 'rows'=>2)); ?>
			</td>
			<td><?php echo $this->Form->input('quantity', array('value'=>$product_val['InvoiceProduct']['qty'], 'id'=>'InvoiceQuantity_'. $key, 'type'=>'number', 'min'=>0, 'name'=>'data[Invoice][p]['. $key .'][quantity]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?></td>
			<td><?php echo $this->Form->input('rate', array('value'=>$product_val['InvoiceProduct']['rate'], 'id'=>'InvoiceRate_'. $key, 'type'=>'number', 'min'=>0, 'name'=>'data[Invoice][p]['. $key .'][rate]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?></td>
			<td><?php echo $this->Form->input('discount', array('value'=>$product_val['InvoiceProduct']['discount'], 'id'=>'InvoiceDiscount_'. $key, 'type'=>'number', 'min'=>0, 'name'=>'data[Invoice][p]['. $key .'][discount]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?></td>
			<td><?php echo $this->Form->input('tax', array('value'=>$product_val['InvoiceProduct']['tax'], 'id'=>'InvoiceTax_'. $key, 'type'=>'number', 'min'=>0, 'name'=>'data[Invoice][p]['. $key .'][tax]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?></td>
			<td><?php echo $this->Form->input('amount', array('value'=>$product_val['InvoiceProduct']['total_amount'], 'id'=>'InvoiceAmount_'. $key, 'type'=>'number', 'min'=>0, 'name'=>'data[Invoice][p]['. $key .'][amount]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?></td>
			<td style="text-align:center;"><?php
				echo $this->Html->link("<i class='fa fa-trash-o'></i>", "javascript:void(0);", array("onClick"=>"deleteRow(". $key .")", "escape"=>false, "class"=>"btn btn-default")); ?>
			</td>
		</tr>

		<script type="text/javascript">
			jQuery(document).ready(function(){	
				jQuery('#InvoiceProduct_<?php echo $key; ?>').autocomplete({
					source:"<?php echo Router::url(array('controller'=>'invoices', 'action'=>'product_info'), true);?>", 
					minLength:1,
					select:function(evt, ui){ //alert(ui.item.user_id);
						this.form.InvoiceProductId_<?php echo $key; ?>.value	= ui.item.product_id;
						this.form.InvoiceQuantity_<?php echo $key; ?>.value	= 1;
						this.form.InvoiceRate_<?php echo $key; ?>.value		= ui.item.rate;
						this.form.InvoiceDiscount_<?php echo $key; ?>.value	= 0;
						this.form.InvoiceTax_<?php echo $key; ?>.value		= ui.item.tax;
						this.form.InvoiceAmount_<?php echo $key; ?>.value	= ui.item.amount; 
					}
				});
			});
		</script><?php
	}

} else { ?>

	<tr id="tr_<?php echo $i; ?>">
		<td><?php 
			echo $this->Form->input('product_id', array('type'=>'hidden',  'id'=>'InvoiceProductId_'. $i, 'name'=>'data[Invoice][p]['. $i .'][product_id]')); 
			echo $this->Form->input('product', array('id'=>'InvoiceProduct_'. $i, 'onkeypress'=>"autocompleteProduct(".$i.")", 'name'=>'data[Invoice][p]['. $i .'][product]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap", 'type'=>'textarea', 'rows'=>2)); ?>
		</td>
		<td><?php echo $this->Form->input('quantity', array('id'=>'InvoiceQuantity_'. $i, 'type'=>'number', 'min'=>0, 'name'=>'data[Invoice][p]['. $i .'][quantity]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?></td>
		<td><?php echo $this->Form->input('rate', array('id'=>'InvoiceRate_'. $i, 'type'=>'number', 'min'=>0, 'name'=>'data[Invoice][p]['. $i .'][rate]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?></td>
		<td><?php echo $this->Form->input('discount', array('id'=>'InvoiceDiscount_'. $i, 'type'=>'number', 'min'=>0, 'name'=>'data[Invoice][p]['. $i .'][discount]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?></td>
		<td><?php echo $this->Form->input('tax', array('id'=>'InvoiceTax_'. $i, 'type'=>'number', 'min'=>0, 'name'=>'data[Invoice][p]['. $i .'][tax]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?></td>
		<td><?php echo $this->Form->input('amount', array('id'=>'InvoiceAmount_'. $i, 'type'=>'number', 'min'=>0, 'name'=>'data[Invoice][p]['. $i .'][amount]', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?></td>
		<td style="text-align:center;"><?php
			echo $this->Html->link("<i class='fa fa-trash-o'></i>", "javascript:void(0);", array("onClick"=>"deleteRow(". $i .")", "escape"=>false, "class"=>"btn btn-default")); ?>
		</td>
	</tr>

	<script type="text/javascript">
		function autocompleteProduct(id) {
			 
			jQuery('#InvoiceProduct_'+id).autocomplete({
				source:"<?php echo Router::url(array('controller'=>'invoices', 'action'=>'product_info'), true);?>", 
				minLength:1,
				select:function(evt, ui){ //alert(ui.item.user_id);
					this.form.InvoiceProductId_<?php echo $i; ?>.value	= ui.item.product_id;
					this.form.InvoiceQuantity_<?php echo $i; ?>.value	= 1;
					this.form.InvoiceRate_<?php echo $i; ?>.value		= ui.item.rate;
					this.form.InvoiceDiscount_<?php echo $i; ?>.value	= 0;
					this.form.InvoiceTax_<?php echo $i; ?>.value		= ui.item.tax;
					this.form.InvoiceAmount_<?php echo $i; ?>.value	= ui.item.amount; 
				}
			});
		}
	</script><?php  
} ?>