<style>.ui-autocomplete{ z-index:99999999; }</style>
<div class="row">
	<div class="col-lg-5"> 		
		<div class="form-group"><?php
			$full_name = '';
			$attachmentData = array();
			$payment_options = '1';
			$action = isset($this->params['action']) ? $this->params['action'] : '';
			if($action=='admin_edit') {
				$full_name = $this->request->data['User']['first_name'].' '.$this->request->data['User']['last_name'];
				$payment_options = $this->request->data['Invoice']['payment_options'];
				$attachmentData = $this->General->getAttachment($this->request->data['Invoice']['id']);
			} 
		 	
			echo $this->Form->input('user_id', array('id'=>'SaleUserId', 'type'=>'hidden')); ?>
			
			<label class="control-label">
				<div class="left">Customer Name<span class='red bold'>*</span></div>
				<div class="left position-relative" id='CUST'>&nbsp;<?php 
					echo $this->Html->link('<i class="fa fa-question-circle"></i>', "javascript:void(0)", array('escape'=>false)); ?>
				</div><div class="clear"></div>				
				<script>													
					var tooltipTimeout;					
					$("#CUST").hover(function(){
						tooltipTimeout = setTimeout(showTooltip_CUST, 2);
					},  hideTooltip_CUST);
					
					function showTooltip_CUST(){
						var tooltip = jQuery('<div id="tooltip_CUST" class="tooltip1">Select customer name from auto generated popup.</div>');
						tooltip.appendTo($("#CUST"));
					}

					function hideTooltip_CUST(){
						clearTimeout(tooltipTimeout);
						$("#tooltip_CUST").fadeOut().remove();
					}
				</script>
			</label>
			<div class="controls"><?php  
				echo $this->Form->input('name', array('value'=>$full_name, 'div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div> 
		
		<div class="form-group">
			<label class="control-label">Invoice Number<span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('invoice_number', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Order Number</label>
			<div class="controls"><?php  
				echo $this->Form->input('order_number', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
		
		
	</div>	 
	
	<div class="col-lg-1"></div>
	<div class="col-lg-5">

		<div class="form-group">
			<label class="control-label">Invoice Date<span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('invoice_date', array('type'=>'text', 'div'=>false, 'label'=>false, "class" => "datepicker form-control")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Due Date<span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('due_date', array('type'=>'text', 'div'=>false, 'label'=>false, "class" => "datepicker form-control")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Sales Person</label>
			<div class="controls"><?php  
				echo $this->Form->input('sales_person', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
	</div>
	<div class="col-lg-1"></div>
</div>



<div class="row">
	<div class="col-lg-12" style="margin-bottom:5px">
		<table class="table m-n" style="border:1px solid #dbe0e2;">
			<thead style="background:#DBE0E2;">
				<tr>
					<th style="width:30%;">Product</th>
					<th>Quantity</th>
					<th>Rate</th>
					<th>Discount</th>
					<th>Tax</th>
					<th>Amount</th>
					<th style="width:20px;"></th>
				</tr>
			</thead>
			
			<tbody id="updateRow"><?php
				echo $this->element('Admin/Invoice/add_product'); ?>
			</tbody>
		</table>
		
		<p style="margin-top:5px"> 
			<span style="display:none;" id="wait">Please wait...</span><?php		
			echo $this->Form->input('row_id', array('type'=>'hidden', 'id'=>'SaleRowId', 'default'=>1));
			echo $this->Html->link("Add Another Product", "javascript:void(0);", array("id"=>"add_row", "onClick"=>"addRow()", "escape"=>false, 'class'=>'btn btn-info btn-sm')); ?>
		</p>
		
	</div>
</div>



<div class="row">
	<div class="col-lg-12">
		<div class="form-group">
			<label class="control-label">Customer Notes</label>
			<div class="controls"><?php  
				echo $this->Form->input('customer_note', array('div'=>false, 'label'=>false, "class" => "form-control", "rows"=>2)); ?> 
			</div>
		</div>
	</div>
</div> 

<div class="row">
	<div class="col-lg-12">
		<div class="form-group">
			<label class="control-label">Payment Options</label>
			<div class="controls"><?php  
			$options = array(
				'1' => 'Standard&nbsp;&nbsp;',
				'2' => 'Business'
			);

			$attributes = array(
				'legend' => false,
				'value' => $payment_options, 
			);
 			echo $this->Form->radio('payment_options', $options, $attributes);  ?> 
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="form-group">
			<label class="control-label">Terms & Conditions</label>
			<div class="controls"><?php  
				echo $this->Form->input('term_condition', array('div'=>false, 'label'=>false, "class" => "form-control", "rows"=>2)); ?> 
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="form-group">
			<label class="control-label">Attach File</label>
			<div class="controls"><?php  
				echo $this->Form->file('attach', array('name'=>'data[Invoice][attach][]', 'multiple'=>'multiple', 'div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
	</div>
</div><?php

if(!empty($attachmentData)) { ?>
	<div class="row">
		<div class="col-lg-12">
			<div class="form-group"><?php
				
					foreach($attachmentData as $attach_val) { ?>
						<label title="Remove" style="cursor: pointer;" class="control-label attach_cls_<?php echo $attach_val['InvoiceAttachment']['id']; ?>" onclick="removeImg('<?php echo $attach_val['InvoiceAttachment']['id']; ?>')" ><i style="font-size:15px;" class="fa fa-times danger" aria-hidden="true"></i>&nbsp;<?php echo $attach_val['InvoiceAttachment']['file_name']; ?>&nbsp;</label><?php 
					}?>
			</div>
		</div>
	</div><?php 
} ?> 


	
<div class="row">
	<div class="col-lg-6">
		<div class="form-group">
			<label class="control-label">Email To</label>
			<div class="controls" style='position:relative;'><?php  
				//echo "<div style='float:left; width:2%;'>". $this->Form->input('email_to_chk', array('type'=>'checkbox', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")) ."</div>";
				//echo "<div style='float:left; width:90%;'>". $this->Form->input('email_to', array('div'=>false, 'label'=>false, "class" => "form-control m-wrap")) ."</div>"; 
				
				echo $this->Form->input('email_to_chk', array('type'=>'checkbox', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap", "style"=>"position:absolute; top:-4px; width:20px; left:5px;")); 
				echo $this->Form->input('email_to', array('div'=>false, 'label'=>false, "class" => "form-control m-wrap", 'style'=>'padding-left:30px;')); ?> 
			</div>
		</div>
	</div>
</div>
	
	
<script type="text/javascript">
	function deleteRow(id){
		if(id){
			jQuery('#tr_'+ id).remove();
		}
	}
	
	
	function removeImg(id){
		jQuery('.attach_cls_'+id).remove();
		jQuery.ajax({
			type: "POST",
			url: '<?php echo Router::url(array('admin'=>true, 'controller'=>'invoices', 'action'=>'delete_img'), true); ?>',
			data:'id='+ id,
			dataType:"html", 
			success: function(data){ 
			 
			},
			complete: function(data){
				 
			}
		}); 
		
	}	
	
	function addRow(){
		jQuery('#add_row').hide();
		jQuery('#wait').show();
		var row_id = jQuery("#SaleRowId").val(); 
		jQuery.ajax({
			type: "POST",
			url: '<?php echo Router::url(array('admin'=>true, 'controller'=>'invoices', 'action'=>'add_row'), true); ?>',
			data:'row_id='+ row_id,
			dataType:"html", 
			success: function(data){ 
				jQuery('#updateRow').append(data);
				
				row_id = parseInt(row_id)+1; 
				jQuery("#SaleRowId").val(row_id);
			},
			complete: function(data){
				jQuery('#add_row').show();
				jQuery('#wait').hide();
			}
		}); 
		
	}
	
	
    $(function() {
		$( ".datepicker" ).datepicker({
			dateFormat: 'yy-mm-dd', 
			changeMonth: true,
			changeYear: true,
            yearRange : 'c-1:c+5'
		});		
    });
	
	
	
	
	
	jQuery(document).ready(function(){		
		jQuery('#InvoiceName').autocomplete({
			source:"<?php echo Router::url(array('controller'=>'invoices', 'action'=>'get_cust_list'), true);?>", 
			minLength:1,
			select:function(evt, ui){
				this.form.SaleUserId.value	= ui.item.user_id;
				this.form.InvoiceName.value	= ui.item.email;
				//	this.form.User.value	= ui.item.Lat;
				//this.form.User.value 	    = ui.item.Lng;
			}
		});
	});
</script>