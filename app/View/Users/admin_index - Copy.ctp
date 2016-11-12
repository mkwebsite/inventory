<?php
	$role_id 	= (isset($this->params['pass'][0]))?$this->params['pass'][0]:2;
	$status 	= (isset($this->params['pass'][1]))?$this->params['pass'][1]:'';
?>

 
<div class="row margin_btm10">
	<div class="col-lg-8">
		<div class="pageheader">
			<h2><?php echo $title_for_layout; ?></h2>
		</div>
	</div>
	
	<div class="col-lg-4">
		<div class="btn-group btn-group-justified marginTop15px"><?php
			echo $this->Html->link('Add New', array('controller'=>'users', 'action'=>'add', $role_id), array("escape"=>false, "class"=>"btn btn-default"));
			
			$cls = ($status=="1")?"active":"";
			echo $this->Html->link($active .' Active', array('controller'=>'users', 'action'=>'index', $role_id, 1), array("class"=>"btn btn-default ". $cls));
			
			$cls = ($status=="2")?"active":"";
			echo $this->Html->link($inactive .' Inactive', array('controller'=>'users', 'action'=>'index', $role_id, 2), array("class"=>"btn btn-default ". $cls));
			
			$cls = ($status=="")?"active":"";
			echo $this->Html->link($all_user .' All', array('controller'=>'users', 'action'=>'index', $role_id), array("class"=>"btn btn-default ". $cls)); ?>
		</div> 
	</div> 
</div>


<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">Search</header>
			
			<div class="panel-body"><?php
				
					echo $this->Form->create('User', array(
						'url'=>array('controller'=>'users', 'action'=>'index', $role_id, $status), 
						'class'=>'form-inline', 'role'=>'form'
					)); 
				
					$keywords  = $this->Session->read('AdminSearch'); ?>
				
					<div class="form-group">
						<label class="sr-only" for="UserFirstName">Search Keyword</label><?php
						echo $this->Form->input('first_name', array('type'=>'text', 'placeholder'=>'Search Keyword', 'div'=>false, "class"=>"form-control", 'value'=>$keywords, 'label'=>false)); ?>
					</div>&nbsp;<?php
					
					echo $this->Form->submit("Search", array("class"=>"btn btn-success", 'div'=>false)); echo "&nbsp;";
					echo $this->Html->link('Show All', array('controller'=>'users', 'action'=>'index', $role_id, $status), array('escape'=>false, 'class'=>'btn btn-success'));
					
				echo $this->Form->end(); ?>
			</div>
		</section>
	</div>
</div><?php 

echo $this->element('Admin/paging_counter'); ?>

<div class="row">
	<div class="col-lg-12">
		<section class="panel"><?php
			
			App::uses('CakeNumber', 'Utility'); 
			if($data){
				$asc_desc = isset($this->params['named']['direction'])?$this->params['named']['direction']:''; 
				$sort_by  = isset($this->params['named']['sort'])?$this->params['named']['sort']:''; 
				$sort_by  = ($sort_by)?explode('.', $sort_by):''; 
				$sort_by  = isset($sort_by[1])?$sort_by[1]:''; ?>
				
				<table class="dataTable table table-striped table-advance table-hover">
					<thead>
						<tr>
							<th class="sorting<?php echo ($sort_by=='first_name')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('User.first_name', 'First Name'); ?> </span></th>
							<th class="hidden-phone sorting<?php echo ($sort_by=='last_name')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('User.last_name', 'Last Name'); ?> </span></th>
							<th class="hidden-phone sorting<?php echo ($sort_by=='username')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('User.username', 'Email Address'); ?> </span></th>
							<th class="hidden-phone sorting<?php echo ($sort_by=='created')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('User.created', 'Created on'); ?> </span></th>
							<th class="hidden-phone sorting<?php echo ($sort_by=='status')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('User.status', 'Status'); ?> </span></th>
							<th class="actionW">Action</th>
						</tr>
					</thead>
					
					<tbody><?php
						foreach($data as $value){
							$last_name = ($value['User']['last_name'])?$value['User']['last_name']:'----';?>
							<tr>
								<td><?php echo $this->Html->link($value['User']['first_name'], array('action'=>'view', $role_id, $value['User']['id']),array('title'=>'View Details')); ?></td>
								<td class="hidden-phone"><?php echo $this->Html->link($last_name, array('action'=>'view', $role_id, $value['User']['id']),array('title'=>'View Details')); ?></td>
								<td class="hidden-phone"><?php echo $this->Html->link($value['User']['username'], array('action'=>'view', $role_id, $value['User']['id']),array('title'=>'View Details')); ?></td>
								<td class="hidden-phone "><?php echo date('M d, Y', strtotime($value['User']['created'])); ?></td>
								<td class=" hidden-phone "> <?php
									if($value['User']['status']==1) {
										echo $this->Html->link(Configure::read('Status.' . $value['User']['status']), array('action'=>'status', $role_id, $value['User']['id']), array('title'=>'Deactivate', 'style'=>'color:#539D00;'));
									} else if($value['User']['status']==2)  {
										echo $this->Html->link(Configure::read('Status.' . $value['User']['status']), array('action'=>'status', $role_id, $value['User']['id']), array('title'=>'Activate', 'style'=>'color:#FF3D28;'));
									} ?>
								</td>
								<td>
									<div class="btn-group">
										<button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown">Action <span class="caret"></span></button>
										<ul class="dropdown-menu dropdown-menu-new" role="menu">
											<li><?php echo $this->Html->link('<i class="fa fa-pencil"></i> Edit', array('controller'=>'users', 'action'=>'edit', $role_id, $value['User']['id']), array('escape'=>false)); ?></li>
											<?php /* <li><?php echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', "#myModal2_". $value['User']['id'], array('data-toggle'=>'modal', 'escape'=>false)); ?></li> */ ?>
											<li><?php echo $this->Html->link('<i class="fa fa-credit-card"></i> View Details', array('controller'=>'users', 'action'=>'view', $role_id, $value['User']['id']), array('escape'=>false)); ?></li>
										</ul>
									</div>
								</td>
							</tr>
				
							<div class="modal fade" id="myModal2_<?php echo $value['User']['id']; ?>">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h3 class="modal-title">Delete!!</h3>
										</div>
										<div class="modal-body">Are you sure, you want to delete this record?</div>
										<div class="modal-footer">
											<button data-dismiss="modal" class="btn btn-default" type="button">Close</button><?php
											echo $this->Html->link('Confirm', array('controller'=>'users', 'action'=>'delete', $role_id, $value['User']['id']), array('data-toggle'=>'modal', 'escape'=>false, 'class'=>'btn btn-warning')) ; ?>
										</div>
									</div>
								</div>
							</div><?php							
						} ?>				  
					</tbody>
				</table><?php
				
				$this->Paginator->options(array('url' => $this->passedArgs));
				echo $this->element('Admin/admin_pagination', array("paging_model_name"=>"User", "total_title"=>"Users List")); 
				
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