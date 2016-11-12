<div class="row">
	<div class="col-lg-6">
		
		<div class="form-group">
			<label class="control-label">First Name <span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('first_name', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Last Name</label>
			<div class="controls"><?php  
				echo $this->Form->input('last_name', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label"> Email <span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('username', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>  
		
		<div class="form-group">
			<label class="control-label">Mobile# <span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('mobile', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div> 
		
		<div class="form-group">
			<label class="control-label">Phone#</label>
			<div class="controls"><?php  
				echo $this->Form->input('phone', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
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
			<label class="control-label">About <?php echo $lable; ?></label>
			<div class="controls"><?php  
				echo $this->Form->input('about_you', array('div'=>false, 'label'=>false, "class"=>"form-control", 'rows'=>2)); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Address <span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('address', array('div'=>false, 'label'=>false, "class"=>"form-control", 'rows'=>2)); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">City <span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('city', array('div'=>false, 'label'=>false, "class" => "form-control state")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">State <span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('state', array('div'=>false, 'label'=>false, "class" => "form-control state")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Zip Code <span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('zip_code', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Country <span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('country_id', array('empty'=>'Select country', 'div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Fax#</label>
			<div class="controls"><?php  
				echo $this->Form->input('fax', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div> 
		
		
	</div>
	<div class="col-lg-2">&nbsp;</div>
	
</div>