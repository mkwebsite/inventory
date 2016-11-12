<div class="row">
	<div class="col-lg-5">
		<div class="form-group">
			<label class="control-label">
				<div class="left">Account<span class='red bold'>*</span></div>
				<div class="left position-relative" id='TrackOrder'>&nbsp;<?php 
					echo $this->Html->link('<i class="fa fa-question-circle"></i>', "javascript:void(0)", array('escape'=>false)); ?>
				</div><div class="clear"></div>				
				<script>													
					var tooltipTimeout;					
					$("#TrackOrder").hover(function(){
						tooltipTimeout = setTimeout(showTooltip_TrackOrder, 2);
					},  hideTooltip_TrackOrder);
					
					function showTooltip_TrackOrder(){
						var tooltip = jQuery('<div id="tooltip_TrackOrder" class="tooltip1">All Inventory related transactions are displayed in this account.</div>');
						tooltip.appendTo($("#TrackOrder"));
					}

					function hideTooltip_TrackOrder(){
						clearTimeout(tooltipTimeout);
						$("#tooltip_TrackOrder").fadeOut().remove();
					}
				</script>
			</label>
			
			<div class="controls"><?php  
				echo $this->Form->input('track_account', array('options'=>Configure::read('TrackAccount'), 'default'=>3, 'div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">
				<div class="left">Initial Stock</div>
				<div class="left position-relative" id='InitialStock'>&nbsp;<?php 
					echo $this->Html->link('<i class="fa fa-question-circle"></i>', "javascript:void(0)", array('escape'=>false)); ?>
				</div><div class="clear"></div>				
				<script>													
					var tooltipTimeout;					
					$("#InitialStock").hover(function(){
						tooltipTimeout = setTimeout(showTooltip_InitialStock, 2);
					},  hideTooltip_InitialStock);
					
					function showTooltip_InitialStock(){
						var tooltip = jQuery('<div id="tooltip_InitialStock" class="tooltip1">Initial stock refers to the quantity of the items on hand before you start tracking inventory for the item</div>');
						tooltip.appendTo($("#InitialStock"));
					}

					function hideTooltip_InitialStock(){
						clearTimeout(tooltipTimeout);
						$("#tooltip_InitialStock").fadeOut().remove();
					}
				</script>
			</label>
			
			<div class="controls"><?php  
				echo $this->Form->input('initial_stock', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
	</div>
	
    <div class="col-lg-2">&nbsp;</div>
	
	<div class="col-lg-4"> 
		
		<div class="form-group">
			<label class="control-label">Preferred Vendor<span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('user_id', array('empty'=>'Please Select', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">
				<div class="left">Reorder Level</div>
				<div class="left position-relative" id='Reorder'>&nbsp;<?php 
					echo $this->Html->link('<i class="fa fa-question-circle"></i>', "javascript:void(0)", array('escape'=>false)); ?>
				</div><div class="clear"></div>				
				<script>													
					var tooltipTimeout;					
					$("#Reorder").hover(function(){
						tooltipTimeout = setTimeout(showTooltip_Reorder, 2);
					},  hideTooltip_Reorder);
					
					function showTooltip_Reorder(){
						var tooltip = jQuery('<div id="tooltip_Reorder" class="tooltip1">Reorder level refers to the quantity of an item below which an item is considered to be low on stock</div>');
						tooltip.appendTo($("#Reorder"));
					}

					function hideTooltip_Reorder(){
						clearTimeout(tooltipTimeout);
						$("#tooltip_Reorder").fadeOut().remove();
					}
				</script>
			</label>
			
			<div class="controls"><?php  
				echo $this->Form->input('reorder_level', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
	</div>
	<div class="col-lg-1">&nbsp;</div>
	
</div>