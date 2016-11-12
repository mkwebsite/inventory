<div class="row">
	<div class="col-lg-6"><?php  
		
		echo ($this->Form->hidden('first_name')); 
		echo ($this->Form->hidden('last_name')); 
		echo ($this->Form->hidden('username')); ?>
	
		<div class="form-group">
			<label class="control-label"><?php 
				echo "Name: ";
				echo ($this->request->data['User']['first_name'] .' '. $this->request->data['User']['last_name']);
				echo "<br />";
				echo "Email Address: ";
				echo ($this->request->data['User']['username']); ?> 
			</label>
		</div>
		
		<div class="form-group">
			<label class="control-label">New Password <span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('new_password', array('type'=>'password', 'required', 'div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
	
		<div class="form-group">
			<label class="control-label">Confirm Password <span class='red bold'>*</span></label>
			<div class="controls"><?php  
				echo $this->Form->input('confirm_password', array('type'=>'password', 'required', 'div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
		
	</div>
		
	<div class="col-lg-8">&nbsp;</div>
	
</div>