<div class="row">
	<div class="col-lg-5"> 		
		<div class="form-group">
			<label class="control-label">Selling Price<span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('selling_price', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>  
		
		<div class="form-group">
			<label class="control-label">
				<div class="left">Account<span class='red bold'>*</span></div>
				<div class="left position-relative" id='ACC'>&nbsp;<?php 
					echo $this->Html->link('<i class="fa fa-question-circle"></i>', "javascript:void(0)", array('escape'=>false)); ?>
				</div><div class="clear"></div>				
				<script>													
					var tooltipTimeout;					
					$("#ACC").hover(function(){
						tooltipTimeout = setTimeout(showTooltip_ACC, 2);
					},  hideTooltip_ACC);
					
					function showTooltip_ACC(){
						var tooltip = jQuery('<div id="tooltip_ACC" class="tooltip1">All transactions related to the products you sell will be displayed in this account</div>');
						tooltip.appendTo($("#ACC"));
					}

					function hideTooltip_ACC(){
						clearTimeout(tooltipTimeout);
						$("#tooltip_ACC").fadeOut().remove();
					}
				</script>
			</label>
			
			<div class="controls"><?php  
			echo $this->Form->input('sales_account', array('options'=>Configure::read('SalesAccount'), 'default'=>3, 'div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Description</label>
			<div class="controls"><?php  
				echo $this->Form->input('sales_desc', array('div'=>false, 'label'=>false, "class" => "form-control", "rows"=>3)); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Sales Tax</label>
			<div class="controls"><?php  
				echo $this->Form->input('sales_tax', array('div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?> 
			</div>
		</div>
	</div>
	
    <div class="col-lg-2">&nbsp;</div>
	
	<div class="col-lg-4"  style="padding-right:0px;">
		 
	</div>
	<div class="col-lg-1">&nbsp;</div>
	
</div>