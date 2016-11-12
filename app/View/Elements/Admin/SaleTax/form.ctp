<div class="row">
	<div class="col-lg-4">
		
		<div class="form-group">
			<label class="control-label">State<span class='red bold'>*</span></label>
			<div class="controls"><?php  
			echo $this->Form->input('state', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">State Code<span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('state_code', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Zip Code<span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('zip_code', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>  
			
		<div class="form-group">
			<label class="control-label">Tax Region Code</label>
			<div class="controls"><?php  
				echo $this->Form->input('tax_region_code', array('div'=>false, 'label'=>false, "class"=>"form-control")); ?> 
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
			<label class="control-label">Combined Rate<span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('combined_rate', array('placeholder'=>'Rates Eg:9.025', 'div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div> 
		
		<div class="form-group">
			<label class="control-label">State Rate</label>
			<div class="controls"><?php  
				echo $this->Form->input('state_rate', array('placeholder'=>'Rates Eg:9.025', 'div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div> 
			
		<div class="form-group">
			<label class="control-label">County Rate</label>
			<div class="controls"><?php  
				echo $this->Form->input('county_rate', array('placeholder'=>'Rates Eg:9.025', 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">City Rate</label>
			<div class="controls"><?php  
				echo $this->Form->input('city_rate', array('placeholder'=>'Rates Eg:9.025', 'div'=>false, 'label'=>false, "class"=>"form-control")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Special Rate</label>
			<div class="controls"><?php  
				echo $this->Form->input('special_rate', array('placeholder'=>'Rates Eg:9.025', 'div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
	</div>
	<div class="col-lg-2">&nbsp;</div>
	
</div>