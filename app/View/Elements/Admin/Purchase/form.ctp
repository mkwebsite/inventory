<style>.ui-autocomplete{ z-index:99999999; }</style>
<div class="row">
	<div class="col-lg-5"> 		
		<div class="form-group"><?php
			$full_name = '';
			$customer_name = '';
			$deliver_type = '';
			$action = isset($this->params['action']) ? $this->params['action'] : '';
			if($action=='admin_edit') {
				
				$first_name = isset($this->request->data['User']['first_name'])?$this->request->data['User']['first_name']:'';
				$last_name = isset($this->request->data['User']['last_name'])?$this->request->data['User']['last_name']:'';
				$deliver_to = isset($this->request->data['Purchase']['deliver_to'])?$this->request->data['Purchase']['deliver_to']:'';
				$deliver_type = isset($this->request->data['Purchase']['deliver_type'])?$this->request->data['Purchase']['deliver_type']:'';
				
				//echo $deliver_type; die; 
				
				$full_name = $first_name.' '.$last_name; 
				
				if($deliver_type==2) {
					$customer_user_data = $this->General->getDeliverTo($deliver_to); 
					$first_name = isset($customer_user_data['User']['first_name'])?$customer_user_data['User']['first_name']:'';
					$last_name = isset($customer_user_data['User']['last_name'])?$customer_user_data['User']['last_name']:'';
					$customer_name = $first_name.' '.$last_name; 
				}
			} 
			
			//echo $deliver_type; die; 
		 	
			echo $this->Form->input('user_id', array('id'=>'PurchaseUserId', 'type'=>'hidden')); ?>
			
			<label class="control-label">
				<div class="left">Vendor Name<span class='red bold'>*</span></div>
				<div class="left position-relative" id='CUST'>&nbsp;<?php 
					echo $this->Html->link('<i class="fa fa-question-circle"></i>', "javascript:void(0)", array('escape'=>false)); ?>
				</div><div class="clear"></div>				
				<script>													
					var tooltipTimeout;					
					$("#CUST").hover(function(){
						tooltipTimeout = setTimeout(showTooltip_CUST, 2);
					},  hideTooltip_CUST);
					
					function showTooltip_CUST(){
						var tooltip = jQuery('<div id="tooltip_CUST" class="tooltip1">Select vendor name from auto generated popup.</div>');
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
			<label class="control-label">Purchases Order#<span class='red bold'>*</span></label>
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
			<label class="control-label">Date<span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('date', array('type'=>'text', 'div'=>false, 'label'=>false, "class" => "datepicker form-control m-wrap")); ?> 
			</div>
		</div>		
	</div>	 
	
	<div class="col-lg-1"></div>
	<div class="col-lg-5">
		<div class="form-group">
			<label class="control-label">Expected Delivery Date</label>
			<div class="controls"><?php  
				echo $this->Form->input('expected_delivery_date', array('type'=>'text', 'div'=>false, 'label'=>false, "class" => "datepicker form-control m-wrap")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Shipment Preference</label>
			<div class="controls"><?php  
				echo $this->Form->input('shipment_preference', array('div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Item Rates Are</label>
			<div class="controls"><?php  
				$type_item = array('1'=>'Tax Exclusive','2'=>'Tax Inclusive');
				echo $this->Form->input('item_rates_are', array('options'=>$type_item, 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?> 
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
				echo $this->element('Admin/Purchase/add_product'); ?>
			</tbody>
		</table>
		
		<p style="margin-top:5px"> 
			<span style="display:none;" id="wait">Please wait...</span><?php		
			echo $this->Form->input('row_id', array('type'=>'hidden', 'id'=>'PurchaseRowId', 'default'=>1));
			echo $this->Html->link("Add Another Product", "javascript:void(0);", array("id"=>"add_row", "onClick"=>"addRow()", "escape"=>false, 'class'=>'btn btn-info btn-sm')); ?>
		</p>
		
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
	<div class="col-lg-12">
		<div class="form-group mb">
			<label class="control-label">Deliver To</label>
			<div class="controls"><?php  
				$options2= array(
					'1' => 'Organization&nbsp;&nbsp;',
					'2' => 'Customer',
				);
				$attributes2 = array(
					'legend' => false, 
					'value' => $deliver_type,
				);
				echo $this->Form->radio('deliver_to', $options2, $attributes2, array("class" => "form-control m-wrap"));
				  ?> 
			</div>
		</div>
	</div>
</div>

<?php 
$user_id = $this->Session->read('Auth.User.id');	
$address_user = $this->General->getUseraddress($user_id); 
$street = isset($address_user['UserBillingAddress']['street'])?$address_user['UserBillingAddress']['street'].', ':'';
$city = isset($address_user['UserBillingAddress']['city'])?$address_user['UserBillingAddress']['city'].', ':'';
$state = isset($address_user['UserBillingAddress']['state'])?$address_user['UserBillingAddress']['state'].', ':'';
$zip_code = isset($address_user['UserBillingAddress']['zip_code'])?$address_user['UserBillingAddress']['zip_code'].', ':'';
$country = isset($address_user['UserBillingAddress']['country'])?$address_user['UserBillingAddress']['country'].', ':'';
$phone = isset($address_user['UserBillingAddress']['phone'])?$address_user['UserBillingAddress']['phone']:'';

$full_address = $street.$city.$state.$country.$zip_code.$phone; 

?>

<div class="form-group" id="organizationHtml" style="<?php echo ($deliver_type==1)?'':'display:none;' ?>">
	<div class="controls"><?php echo $full_address; ?></div>
</div>

<div class="form-group" id="customerHtml" style="<?php echo ($deliver_type==2)?'':'display:none;' ?>">
	<div class="controls"><?php  
		echo $this->Form->input('customer_id', array('id'=>'customerUserId', 'type'=>'hidden')); 
		echo $this->Form->input('customer_user_name', array('value'=>$customer_name, 'placeholder'=>'Customer Name', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?> 
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="form-group">
			<label class="control-label">Notes</label>
			<div class="controls"><?php  
				echo $this->Form->input('cust_note', array('div'=>false, 'label'=>false, "class" => "form-control m-wrap", "rows"=>2)); ?> 
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
		var row_id = jQuery("#PurchaseRowId").val(); 
		jQuery.ajax({
			type: "POST",
			url: '<?php echo Router::url(array('admin'=>true, 'controller'=>'purchases', 'action'=>'add_row'), true); ?>',
			data:'row_id='+ row_id,
			dataType:"html", 
			success: function(data){ 
				jQuery('#updateRow').append(data);
				
				row_id = parseInt(row_id)+1; 
				jQuery("#PurchaseRowId").val(row_id);
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
		jQuery('#PurchaseName').autocomplete({
			source:"<?php echo Router::url(array('controller'=>'purchases', 'action'=>'get_cust_list'), true);?>", 
			minLength:1,
			select:function(evt, ui){
				this.form.PurchaseUserId.value	= ui.item.user_id;
				this.form.PurchaseName.value	= ui.item.email;
				//	this.form.User.value	= ui.item.Lat;
				//this.form.User.value 	    = ui.item.Lng;
			}
		});
		
		jQuery('#PurchaseCustomerUserName').autocomplete({
			source:"<?php echo Router::url(array('controller'=>'purchases', 'action'=>'get_cust_user_list'), true);?>", 
			minLength:1,
			select:function(evt, ui){
				this.form.customerUserId.value	= ui.item.user_id;
				this.form.PurchaseCustomerUserName.value	= ui.item.email;
				//	this.form.User.value	= ui.item.Lat;
				//this.form.User.value 	    = ui.item.Lng;
			}
		});
		
		$("#PurchaseDeliverTo1").click(function() {
			$('#organizationHtml').show();
			$('#customerHtml').hide();
		});
		
		$("#PurchaseDeliverTo2").click(function() {
			$('#customerHtml').show();
			$('#organizationHtml').hide();
		});
		
		
		
	});
</script>