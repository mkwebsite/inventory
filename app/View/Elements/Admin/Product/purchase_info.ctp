<div class="row">
	<div class="col-lg-5"> 		
		<div class="form-group">
			<label class="control-label">Cost Price<span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('cost_price', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>  
		
		<div class="form-group">
			<label class="control-label">
				<div class="left">Account<span class='red bold'>*</span></div>
				<div class="left position-relative" id='PACC'>&nbsp;<?php 
					echo $this->Html->link('<i class="fa fa-question-circle"></i>', "javascript:void(0)", array('escape'=>false)); ?>
				</div><div class="clear"></div>				
				<script>													
					var tooltipTimeout;					
					$("#PACC").hover(function(){
						tooltipTimeout = setTimeout(showTooltip_PACC, 2);
					},  hideTooltip_PACC);
					
					function showTooltip_PACC(){
						var tooltip = jQuery('<div id="tooltip_PACC" class="tooltip1">All transactions related to the products you purchase will be displayed in this account</div>');
						tooltip.appendTo($("#PACC"));
					}

					function hideTooltip_PACC(){
						clearTimeout(tooltipTimeout);
						$("#tooltip_PACC").fadeOut().remove();
					}
				</script>
			</label>
			
			<div class="controls"><?php  
			echo $this->Form->input('purchase_account', array('options'=>Configure::read('PurchasesAccount'), 'default'=>3, 'div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Description</label>
			<div class="controls"><?php  
				echo $this->Form->input('purchase_desc', array('div'=>false, 'label'=>false, "class" => "form-control", "rows"=>3)); ?> 
			</div>
		</div> 
	</div>
	
    <div class="col-lg-2">&nbsp;</div>
	
	<div class="col-lg-4"  style="padding-right:0px;">
		 
	</div>
	<div class="col-lg-1">&nbsp;</div>
	
</div>