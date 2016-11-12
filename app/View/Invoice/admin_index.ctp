<?php
	$pageCount = (isset($this->params['paging']['Sale']['pageCount']) and $this->params['paging']['Sale']['pageCount'])?$this->params['paging']['Sale']['pageCount']:0;
	if($pageCount > 10){ ?>
		<style>
			.dataTables_paginate > .active{
				background: #f1f2f7 none repeat scroll 0 0;
				border: 2px solid #ddd !important;
				padding: 5px 10px;
			}
		</style><?php
	} 
	
	$status = (isset($this->params['pass'][0]))?$this->params['pass'][0]:'';	
?>

<ol class="breadcrumb">
	<li class=""><?php echo $this->Html->link('Dashboard', array('admin'=>true, 'controller'=>'admins', 'action'=>'dashboard')); ?></li>
	<li class=""><?php echo $this->Html->link($title_for_layout, "javascript:void(0);"); ?></li>
</ol>

<div class="container-fluid">   
	<div data-widget-group="group1"> 
	
		<div class="col-lg-12 p-n">
			<div class="col-lg-4 p-n">
				<div class="pageheader">
					<h2><?php echo $title_for_layout; ?></h2>
				</div>
			</div> 
		</div> 
	 
 

		<div class="row">
			<div class="col-lg-12">
				<section class="panel">
					<div class="panel-heading">
						<h2>Search</h2>
						<div class="options" style="float: right;"><?php 
							echo $this->Html->link('Add New', array('controller'=>'invoices', 'action'=>'add'), array("class"=>"btn btn-info")); ?> 
						</div> 
					</div> 
					
					<div class="panel-body"><?php
						echo $this->Form->create('Invoice', array(
							'url'=>array('controller'=>'invoices', 'action'=>'index', $status), 
							'class'=>'form-inline', 'role'=>'form'
						)); 
						
							$keywords  = $this->Session->read('AdminSearch'); ?>
						
							<div class="form-group" style="width:30%;">
								<label class="sr-only" for="UserFirstName">Search Keyword</label><?php
								echo $this->Form->input('keyword', array('type'=>'text', 'placeholder'=>'Search Keyword', 'div'=>false, "class"=>"form-control", 'value'=>$keywords, 'label'=>false, 'style'=>'width:100%')); ?>
							</div>&nbsp;<?php
						
							echo $this->Form->submit("Search", array("class"=>"btn btn-info", 'div'=>false)); echo "&nbsp;";
							echo $this->Html->link('Show All', array('controller'=>'invoices', 'action'=>'index'), array('escape'=>false, 'class'=>'btn btn-info'));
							
						echo $this->Form->end(); ?>
					</div>
				</section>
			</div>
		</div>
		
		
		<div class="modal  modal fade" id="myModal2_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 class="modal-title">Delete!!</h3>
					</div>
					<div class="modal-body">Are you sure, you want to delete this record?</div><?php 
					
					
					echo $this->Form->create('Invoice', 
							array('type'=>'file', 'url'=>array('controller'=>'invoices', 'action'=>'delete'),
								'inputDefaults' => array(
									'error' => array(
										'attributes' => array(
											'wrap' => 'span',
											'class' => 'danger'
										)
									)
								),
								'role'=>'form'
						)); 
						echo $this->Form->hidden('id', array('type'=>'text', 'id'=>'invoice_id', 'div'=>false, 'label'=>false, "class" => "datepicker form-control")); 
						  ?>
					
					<div class="modal-footer">
						<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
						<button type="submit" class="btn btn-warning"><i class='fa fa-check-square'></i> Confirm</button>
						 
					</div>
					
					<?php echo $this->Form->end(); ?>
					
				</div>
			</div>
		</div>

		<?php //echo $this->element('Admin/paging_counter'); ?>

		<div class="row">
			<div class="col-lg-12">
				<section class="panel">
				 
				
					<div class="panel-heading">
						<h2><?php echo $title_for_layout; ?></h2>
						<div class="panel-ctrls" data-actions-container="" data-action-collapse='{"target": ".panel-body"}'></div>
						<div class="options"> </div>
					</div> <?php
						
					if($data){ 
						$asc_desc = isset($this->params['named']['direction'])?$this->params['named']['direction']:''; 
						$sort_by  = isset($this->params['named']['sort'])?$this->params['named']['sort']:''; 
						$sort_by  = ($sort_by)?explode('.', $sort_by):''; 
						$sort_by  = isset($sort_by[1])?$sort_by[1]:''; ?>
					
						<table class="table m-n">
							<thead>
								<tr>
									<th class="sorting<?php echo ($sort_by=='invoice_date')?'_'.$asc_desc:''; ?> "><span class="m7"><?php echo $this->ExPaginator->sort('Invoice.invoice_date', 'Date'); ?> </span></th>
									<th class="sorting<?php echo ($sort_by=='invoice_number')?'_'.$asc_desc:''; ?> "><span class="m7"><?php echo $this->ExPaginator->sort('Invoice.invoice_number', 'Invoice#'); ?> </span></th>
									<th class="hidden-phone sorting<?php echo ($sort_by=='order_number')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('User.order_number', 'Order Number'); ?> </span></th>
									<th class="sorting<?php echo ($sort_by=='first_name')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('Invoice.first_name', 'Customer Name'); ?> </span></th>
									<th class="sorting<?php echo ($sort_by=='status')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('Invoice.status', 'Status'); ?> </span></th>
									<th class="sorting<?php echo ($sort_by=='due_date')?'_'.$asc_desc:''; ?> "><span class="m7"><?php echo $this->ExPaginator->sort('Invoice.due_date', ' Due Date'); ?> </span></th>
									<?php /*<th class="sorting">Amount</span></th>
									<th class="sorting">Balance Due</span></th>*/ ?>
									<th class="actionW">Action</th>
								</tr>
							</thead>
							
							<tbody><?php
								foreach($data as $value){ ?>
									<tr>
										<td><?php echo $this->Html->link(date('M d, Y', strtotime($value['Invoice']['invoice_date'])), array('controller'=>'invoices', 'action'=>'view', $value['Invoice']['id'])); ?></td>
										<td><?php echo $value['Invoice']['invoice_number']; ?></td>
										<td><?php echo $value['Invoice']['order_number']; ?></td>
										<td><?php echo $value['User']['first_name'] .' '. $value['User']['last_name']; ?></td>  
										<td><?php
											if($value['Invoice']['status']==1){
												echo $this->Html->link('Active', array('action'=>'status',$value['Invoice']['id']), array('title'=>'Deactivate', 'style'=>'color:#539D00;'));
											}else{
												echo $this->Html->link('Inictive', array('action'=>'status',$value['Invoice']['id']), array('title'=>'Activate', 'style'=>'color:#FF3D28;'));
											} ?>
										</td>
										<td><?php echo date('M d, Y', strtotime($value['Invoice']['due_date'])); ?></td>
										<?php /*<td><?php echo $value['Invoice']['order_number']; ?></td>
										<td><?php echo $value['Invoice']['order_number']; ?></td>*/ ?>
										 
										<td>									
											<div class="btn-group">
												<button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown">Action <span class="caret"></span></button>
												<ul class="dropdown-menu dropdown-menu-new" role="menu">
													<li><?php echo $this->Html->link('<i class="fa fa-pencil"></i> Edit', array('controller'=>'invoices', 'action'=>'edit', $value['Invoice']['id']), array('escape'=>false)); ?></li>
													<li><?php echo $this->Html->link('<i class="fa fa-credit-card"></i> View Details', array('controller'=>'invoices', 'action'=>'view', $value['Invoice']['id']), array('escape'=>false)); ?></li>
													<li><?php echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', "#myModal2_". $value['Invoice']['id'], array('onclick'=>'popupShow('.$value['Invoice']['id'].')','data-toggle'=>'modal', 'escape'=>false)); ?></li>
												</ul>
											</div>
										</td>
									</tr>
									

									
									
									<?php
								} ?>				  
							</tbody>
						</table><?php
						
						$this->Paginator->options(array('url' => $this->passedArgs));
						echo $this->element('Admin/admin_pagination', array("paging_model_name"=>"Invoice", "total_title"=>"Invoice Lists")); 
					}else{ ?>			
						<div class="row">
							<div class="col-lg-12">
								<div class="alert alert-danger fade in margin0">
									No Information for Display.
								</div>
							</div>
						</div><?php
					} ?>
				</section>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function popupShow(id){
		$('#invoice_id').val(id);
		$('#myModal2_popup').modal('show'); 
	} 
</script>