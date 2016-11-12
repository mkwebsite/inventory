<div class="row">
	<div class="col-lg-4">
		
		<div class="form-group">
			<label class="control-label">Country Name<span class='red bold'>*</span></label>
			<div class="controls"><?php  
			echo $this->Form->input('name', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Country Code<span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('code', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
			
		<div class="form-group">
			<label class="control-label">Status</label>
			<div class="controls"><?php  
				echo $this->Form->input('status', array('options'=>Configure::read('Status'), 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?> 
			</div>
		</div>
			
	</div>
	
    <div class="col-lg-8">&nbsp;</div>
	
</div>