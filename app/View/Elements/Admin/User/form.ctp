<div class="row">
	<div class="col-lg-4">
		<div class="form-group">
			<label class="control-label">Salutation <span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('salutation', array('options'=>Configure::read('Salutation'), 'div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
		
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
			<label class="control-label">Status</label>
			<div class="controls"><?php  
				echo $this->Form->input('status', array('options'=>Configure::read('Status'), 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?> 
			</div>
		</div> 
	</div>
	
    <div class="col-lg-2">&nbsp;</div>
	<div class="col-lg-4"  style="padding-right:0px;"> 
		
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
			<label class="control-label">Company Name</label>
			<div class="controls"><?php  
				echo $this->Form->input('company_name', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>  
		
		<div class="form-group">
			<label class="control-label">Skype</label>
			<div class="controls"><?php  
				echo $this->Form->input('skype', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>  
		
		<div class="form-group">
			<label class="control-label">Website</label>
			<div class="controls"><?php  
				echo $this->Form->input('website', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div> 
	</div>
	<div class="col-lg-2">&nbsp;</div>
	
</div>