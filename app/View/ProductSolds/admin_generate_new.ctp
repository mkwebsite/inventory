<?php
	$pageCount = (isset($this->params['paging']['Product']['pageCount']) and $this->params['paging']['Product']['pageCount'])?$this->params['paging']['Product']['pageCount']:0;
	if($pageCount > 10){ ?>
		<style>
		.dataTables_paginate > .active{
			background: #f1f2f7 none repeat scroll 0 0;
			border: 2px solid #ddd !important;
			padding: 5px 10px;
		}
		</style><?php
	} 
?>

<div class="row margin_btm15">
	<div class="col-lg-12"><?php
		echo $this->Html->link('Dashboard', array('admin'=>true, 'controller'=>'admins', 'action'=>'dashboard')) ."&nbsp;&nbsp;/&nbsp;&nbsp;";
		echo $this->Html->link($title_for_layout, "javascript:void(0);"); ?>
	</div> 
</div>

<div class="row margin_btm10">
	<div class="col-lg-12">
		<h3 class="page-title margin_top0"><?php echo $title_for_layout; ?></h3>
	</div>
</div>


<?php echo $this->element('Admin/cart_header'); ?>


<div class="row">
	<div class="col-lg-12">
		<section class="panel" style="min-height:300px;"> 
			<header class="panel-heading">Search and Select Customer</header><?php
	
			echo $this->Form->create('ProductSold', 
				array('url' => array('controller'=>'product_solds', 'action'=>'generate_new'),
					'inputDefaults' => array(
						'error' => array(
							'attributes'=>array('wrap'=>'span', 'class'=>'danger')
						)
					), 
					'role'=>'form'
				));

				echo $this->Form->input('user_id', array('id'=>'ProductSoldUserId', 'type'=>'hidden')); ?>

				<div class="panel-body">
					<div class="row">
						<div class="col-lg-4">
							<div class="form-group"><?php
								echo $this->Form->error('user_id'); ?>
								
								<label class="control-label">Customer First Name<span class='red bold'>*</span></label>
								<div class="controls"><?php  
									echo $this->Form->input('first_name', array('id'=>'ProductSoldFirstName', 'placeholder'=>'Search by name, email, phone, city mobile etc.', 'div'=>false, 'label'=>false, "class" => "form-control")); ?> 
									<small>Select customer from auto list.</small>
								</div>
							</div>
						</div>
						
						<div class="col-lg-2"></div>
						
						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label">Customer Last Name</label>
								<div class="controls"><?php  
									echo $this->Form->input('last_name', array('id'=>'ProductSoldLastName', 'div'=>false, 'label'=>false, "class" => "form-control")); ?> 
								</div>
							</div>
						</div>
						
						<div class="col-lg-2"></div>
					</div>
					
					<p>&nbsp;</p>
					
					<div class="row">
						<div class="col-lg-12">
							<button type="submit" class="btn btn-primary"><i class='fa fa-check-square'></i> Generate Order for Selected Customer </button>
						</div>
					</div>
				</div><?php

			echo $this->Form->end(); ?>
			
			
		</section>
	</div>
</div>


<script type="text/javascript">  
	jQuery(document).ready(function(){
		
		jQuery('#ProductSoldFirstName').autocomplete({
			source:"<?php echo Router::url(array('controller'=>'product_solds', 'action'=>'get_cust_list'), true);?>", 
			minLength:1,
			select:function(evt, ui){
				this.form.ProductSoldLastName.value	= ui.item.last_name;
				this.form.ProductSoldUserId.value	= ui.item.user_id;
				//this.form.ProjectZipFrom.value		= ui.item.ZIP;
				//	this.form.User.value		= ui.item.Lat;
				//this.form.User.value 	    = ui.item.Lng;
			}
		});
	});
</script>