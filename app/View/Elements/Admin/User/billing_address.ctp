<div class="row">
	<div class="col-lg-4">
		<div class="form-group">
			<label class="control-label">Street</label>
			<div class="controls"><?php  
				echo $this->Form->input('UserBillingAddress.street', array('type'=>'text', 'div'=>false, 'label'=>false, "class" => "form-control", "rows"=>"3")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">City</label>
			<div class="controls"><?php  
				echo $this->Form->input('UserBillingAddress.city', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label">State</label>
			<div class="controls"><?php  
				echo $this->Form->input('UserBillingAddress.state', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>
	</div>
	
    <div class="col-lg-2">&nbsp;</div>
	<div class="col-lg-4"  style="padding-right:0px;"> 
		<div class="form-group">
			<label class="control-label">Zip Code</label>
			<div class="controls"><?php  
				echo $this->Form->input('UserBillingAddress.zip_code', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div>  
			
		<div class="form-group">
			<label class="control-label">Country</label>
			<div class="controls"><?php  
				echo $this->Form->input('UserBillingAddress.country', array("empty"=>"Select Country", 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?> 
			</div>
		</div> 
		
		<div class="form-group">
			<label class="control-label">Fax#</label>
			<div class="controls"><?php  
				echo $this->Form->input('UserBillingAddress.fax', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div> 
		
		<div class="form-group">
			<label class="control-label">Phone#</label>
			<div class="controls"><?php  
				echo $this->Form->input('UserBillingAddress.phone', array('div'=>false, 'label'=>false, "class" => "form-control")); ?> 
			</div>
		</div> 
	</div>
	<div class="col-lg-2">&nbsp;</div>
	
</div>