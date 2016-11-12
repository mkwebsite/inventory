<div class="row">
	<div class="col-lg-5"> 		
		<div class="form-group">
			<label class="control-label">Name<span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('name', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>  
		
		<div class="form-group">
			<label class="control-label">
				<div class="left">SKU<span class='red bold'>*</span></div>
				<div class="left position-relative" id='SKU'>&nbsp;<?php 
					echo $this->Html->link('<i class="fa fa-question-circle"></i>', "javascript:void(0)", array('escape'=>false)); ?>
				</div><div class="clear"></div>				
				<script>													
					var tooltipTimeout;					
					$("#SKU").hover(function(){
						tooltipTimeout = setTimeout(showTooltip_SKU, 2);
					},  hideTooltip_SKU);
					
					function showTooltip_SKU(){
						var tooltip = jQuery('<div id="tooltip_SKU" class="tooltip1">Stock keeping unit for this product</div>');
						tooltip.appendTo($("#SKU"));
					}

					function hideTooltip_SKU(){
						clearTimeout(tooltipTimeout);
						$("#tooltip_SKU").fadeOut().remove();
					}
				</script>
			</label>
			
			<div class="controls"><?php  
			echo $this->Form->input('sku', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">
				<div class="left">UOM<span class='red bold'>*</span></div>
				<div class="left position-relative" id='UOM'>&nbsp;<?php 
					echo $this->Html->link('<i class="fa fa-question-circle"></i>', "javascript:void(0)", array('escape'=>false)); ?>
				</div><div class="clear"></div>				
				<script>													
					var tooltipTimeout;					
					$("#UOM").hover(function(){
						tooltipTimeout = setTimeout(showTooltip_UOM, 2);
					},  hideTooltip_UOM);
					
					function showTooltip_UOM(){
						var tooltip = jQuery('<div id="tooltip_UOM" class="tooltip1">Unit of Measurement</div>');
						tooltip.appendTo($("#UOM"));
					}

					function hideTooltip_UOM(){
						clearTimeout(tooltipTimeout);
						$("#tooltip_UOM").fadeOut().remove();
					}
				</script>
			</label>
			<div class="controls"><?php  
				echo $this->Form->input('uom', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Status</label>
			<div class="controls"><?php  
				echo $this->Form->input('status', array('options'=>Configure::read('Status'), 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?> 
			</div>
		</div>
	</div>
	
    <div class="col-lg-2">&nbsp;</div>
	
	<div class="col-lg-4"  style="padding-right:0px;">
		<div class="form-group">
			<label class="control-label">
				<div class="left">UPC</div>
				<div class="left position-relative" id='UPC'>&nbsp;<?php 
					echo $this->Html->link('<i class="fa fa-question-circle"></i>', "javascript:void(0)", array('escape'=>false)); ?>
				</div><div class="clear"></div>				
				<script>													
					var tooltipTimeout;
					
					$("#UPC").hover(function(){
						tooltipTimeout = setTimeout(showTooltip_UPC, 2);
					},  hideTooltip_UPC);

					function showTooltip_UPC(){
						var tooltip = jQuery('<div id="tooltip_UPC" class="tooltip1">Twelve digit unique number associated with bar code (Universal Product Code)</div>');
						tooltip.appendTo($("#UPC"));
					}

					function hideTooltip_UPC(){
						clearTimeout(tooltipTimeout);
						$("#tooltip_UPC").fadeOut().remove();
					}
				</script>
			</label>
			<div class="controls"><?php  
				echo $this->Form->input('upc', array('div'=>false, 'label'=>false, "class" => "form-control")); ?>  
			</div>
		</div> 
		
		<div class="form-group">
			<label class="control-label">
				<div class="left">MPN</div>
				<div class="left position-relative" id='MPN'>&nbsp;<?php 
					echo $this->Html->link('<i class="fa fa-question-circle"></i>', "javascript:void(0)", array('escape'=>false)); ?>
				</div><div class="clear"></div>				
				<script>													
					var tooltipTimeout;
					
					$("#MPN").hover(function(){
						tooltipTimeout = setTimeout(showTooltip_MPN, 2);
					},  hideTooltip_MPN);

					function showTooltip_MPN(){
						var tooltip = jQuery('<div id="tooltip_MPN" class="tooltip1">Manufacturing Part Number Unambiguously identifies a part design</div>');
						tooltip.appendTo($("#MPN"));
					}

					function hideTooltip_MPN(){
						clearTimeout(tooltipTimeout);
						$("#tooltip_MPN").fadeOut().remove();
					}
				</script>
			</label>
			<div class="controls"><?php  
				echo $this->Form->input('mpn', array('div'=>false, 'label'=>false, "class" => "form-control")); ?>
			</div>
		</div> 
			
		<div class="form-group">
			<label class="control-label">
				<div class="left">EAN</div>
				<div class="left position-relative" id='EAN'>&nbsp;<?php 
					echo $this->Html->link('<i class="fa fa-question-circle"></i>', "javascript:void(0)", array('escape'=>false)); ?>
				</div><div class="clear"></div>				
				<script>													
					var tooltipTimeout;
					
					$("#EAN").hover(function(){
						tooltipTimeout = setTimeout(showTooltip_EAN, 2);
					},  hideTooltip_EAN);

					function showTooltip_EAN(){
						var tooltip = jQuery('<div id="tooltip_EAN" class="tooltip1">Thirteen digit unique number (International Article Number)</div>');
						tooltip.appendTo($("#EAN"));
					}

					function hideTooltip_EAN(){
						clearTimeout(tooltipTimeout);
						$("#tooltip_EAN").fadeOut().remove();
					}
				</script>
			</label>
			<div class="controls"><?php  
				echo $this->Form->input('ean', array('div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">
				<div class="left">ISBN</div>
				<div class="left position-relative" id='ISBN'>&nbsp;<?php 
					echo $this->Html->link('<i class="fa fa-question-circle"></i>', "javascript:void(0)", array('escape'=>false)); ?>
				</div><div class="clear"></div>				
				<script>													
					var tooltipTimeout;
					
					$("#ISBN").hover(function(){
						tooltipTimeout = setTimeout(showTooltip_ISBN, 2);
					},  hideTooltip_ISBN);

					function showTooltip_ISBN(){
						var tooltip = jQuery('<div id="tooltip_ISBN" class="tooltip1">Thirteen digit unique commercial book identifier (International Standard Book Number)</div>');
						tooltip.appendTo($("#ISBN"));
					}

					function hideTooltip_ISBN(){
						clearTimeout(tooltipTimeout);
						$("#tooltip_ISBN").fadeOut().remove();
					}
				</script>
			</label>
			<div class="controls"><?php  
				echo $this->Form->input('isbn', array('div'=>false, 'label'=>false, "class"=>"form-control")); ?> 
			</div>
		</div>
	</div>
	<div class="col-lg-1">&nbsp;</div>
	
</div>