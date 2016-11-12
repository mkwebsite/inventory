<style>.ui-autocomplete{ z-index:99999999; }</style>
<div class="row">
	<div class="col-lg-5"> 		
		<div class="form-group"><?php
			$full_name = '';
			$action = isset($this->params['action']) ? $this->params['action'] : '';
			if($action=='admin_edit') {
				$full_name = $this->request->data['User']['first_name'].' '.$this->request->data['User']['last_name'];
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
			<label class="control-label">Sales Order#<span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('order_no', array('div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Reference#</label>
			<div class="controls"><?php  
				echo $this->Form->input('reference', array('div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Sales Order Date<span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('order_date', array('type'=>'text', 'div'=>false, 'label'=>false, "class" => "datepicker form-control m-wrap")); ?> 
			</div>
		</div>		
	</div>	 
	
	<div class="col-lg-1"></div>
	<div class="col-lg-5">
		<div class="form-group">
			<label class="control-label">Expected Shipping Date</label>
			<div class="controls"><?php  
				echo $this->Form->input('expected_shipping_date', array('type'=>'text', 'div'=>false, 'label'=>false, "class" => "datepicker form-control m-wrap")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Delivery Method</label>
			<div class="controls"><?php  
				echo $this->Form->input('delivery_method', array('div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Sales Person</label>
			<div class="controls"><?php  
				echo $this->Form->input('sales_person', array('div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?> 
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
				echo $this->element('Admin/Sale/add_product'); ?>
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
				echo $this->Form->input('cust_note', array('div'=>false, 'label'=>false, "class" => "form-control m-wrap", "rows"=>2)); ?> 
			</div>
		</div>
	</div>
</div>
	
<div class="row">
	<div class="col-lg-12">
		<div class="form-group">
			<label class="control-label">Term and Conditions</label>
			<div class="controls"><?php  
				echo $this->Form->input('term_condition', array('div'=>false, 'label'=>false, "class" => "form-control m-wrap", "rows"=>2)); ?> 
			</div>
		</div>
	</div>
</div>
	
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
	
	
	function addRow(){
		jQuery('#add_row').hide();
		jQuery('#wait').show();
		var row_id = jQuery("#SaleRowId").val(); 
		jQuery.ajax({
			type: "POST",
			url: '<?php echo Router::url(array('admin'=>true, 'controller'=>'sales', 'action'=>'add_row'), true); ?>',
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
		jQuery('#SaleName').autocomplete({
			source:"<?php echo Router::url(array('controller'=>'sales', 'action'=>'get_cust_list'), true);?>", 
			minLength:1,
			select:function(evt, ui){
				this.form.SaleUserId.value	= ui.item.user_id;
				this.form.SaleEmailTo.value	= ui.item.email;
				//	this.form.User.value	= ui.item.Lat;
				//this.form.User.value 	    = ui.item.Lng;
			}
		});
	});
</script>