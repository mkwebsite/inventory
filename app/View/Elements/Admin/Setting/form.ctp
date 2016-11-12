<div class="row">
	<div class="col-lg-6"><?php

	
		$ctr = 0;
		foreach($this->request->data as $setting){  
			if(isset($setting['Setting']) and $setting['Setting']){
				echo $this->Form->input($ctr.'.Setting.id', array('value'=>$setting['Setting']['id']));
				echo $this->Form->hidden($ctr.'.Setting.label', array('value'=>$setting['Setting']['label']));
				echo $this->Form->hidden($ctr.'.Setting.slug', array('value'=>$setting['Setting']['slug']));
				echo $this->Form->hidden($ctr.'.Setting.description', array('value'=>$setting['Setting']['description']));
				echo $this->Form->hidden($ctr.'.Setting.type', array('value'=>$setting['Setting']['type'])); ?>
		
				<div class="form-group">
					<label class="control-label"><?php echo $setting['Setting']['label']; /* ?> <span class='red bold'>*</span>*/ ?></label>
					<div class="controls"><?php  
						echo $this->Form->input($ctr.'.Setting.value', array('error'=>false, 'value'=>$setting['Setting']['value'], 'div'=>false, 'label'=>false, "class"=>"form-control"));
						echo $this->Form->error($ctr.'Setting.value', array('class'=>'danger', 'wrap'=>'span')); ?>
						<small><?php echo ($setting['Setting']['description']);?></small>
					</div>
				</div> <?php
				$ctr++;
			}
		} ?>
	</div> 	
</div>