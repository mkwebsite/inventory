<?php
	$pageCount = (isset($this->params['paging']['Country']['pageCount']) and $this->params['paging']['Country']['pageCount'])?$this->params['paging']['Country']['pageCount']:0;
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
	<div class="col-lg-8">
		<h3 class="page-title margin_top0"><?php echo $title_for_layout; ?></h3>
	</div>
	<div class="col-lg-4">
		<div class="btn-group btn-group-justified"><?php
			echo $this->Html->link($active .' Active', array('controller'=>'countries', 'action'=>'index', 1), array("class"=>"btn btn-success"));
			echo $this->Html->link($inactive .' Inactive', array('controller'=>'countries', 'action'=>'index', 2), array("class"=>"btn btn-danger"));
			echo $this->Html->link($all .' All', array('controller'=>'countries', 'action'=>'index'), array("class"=>"btn btn-info")); ?>
		</div> 
	</div> 
</div>

<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">Search</header>
			
			<div class="panel-body"><?php
				$status = (isset($this->params['pass'][0]))?$this->params['pass'][0]:'';
				
				echo $this->Form->create('Country', array(
					'url'=>array('controller'=>'countries', 'action'=>'index', $status), 
					'class'=>'form-inline', 'role'=>'form'
				)); 
				
					$keywords  = $this->Session->read('AdminSearch'); ?>
				
					<div class="form-group">
						<label class="sr-only" for="UserFirstName">Search Keyword</label><?php
						echo $this->Form->input('keyword', array('type'=>'text', 'placeholder'=>'Search Keyword', 'div'=>false, "class"=>"form-control", 'value'=>$keywords, 'label'=>false)); ?>
					</div>&nbsp;<?php
				
					echo $this->Form->submit("Search", array("class"=>"btn btn-success", 'div'=>false)); echo "&nbsp;";
					echo $this->Html->link('Show All', array('controller'=>'countries', 'action'=>'index'), array('escape'=>false, 'class'=>'btn btn-success'));
					
				echo $this->Form->end(); ?>
			</div>
		</section>
	</div>
</div>

<?php echo $this->element('Admin/paging_counter'); ?>

<div class="row">
	<div class="col-lg-12">
		<section class="panel"><?php
				
			if($data){ 
				$asc_desc = isset($this->params['named']['direction'])?$this->params['named']['direction']:''; 
				$sort_by  = isset($this->params['named']['sort'])?$this->params['named']['sort']:''; 
				$sort_by  = ($sort_by)?explode('.', $sort_by):''; 
				$sort_by  = isset($sort_by[1])?$sort_by[1]:''; ?>
			
				<table class="dataTable table table-striped table-advance table-hover">
					<thead>
						<tr>
							<th class="sorting<?php echo ($sort_by=='name')?'_'.$asc_desc:''; ?> "><span class="m7"><?php echo $this->ExPaginator->sort('Country.name', 'Name'); ?> </span></th>
							<th class="hidden-phone sorting<?php echo ($sort_by=='code')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('Country.code', 'Code'); ?> </span></th>
							<th class="sorting<?php echo ($sort_by=='status')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('Country.status', 'Status'); ?> </span></th>
							<th class="actionW">Action</th>
						</tr>
					</thead>
					
					<tbody><?php
						foreach($data as $value){ ?>
							<tr>
								<td><?php echo $value['Country']['name']; ?></td>
								<td class="hidden-phone"><?php echo $value['Country']['code']; ?></td>
								<td><?php
									if($value['Country']['status']==1){
										echo $this->Html->link(Configure::read('Status.' . $value['Country']['status']), array('action'=>'status',$value['Country']['id']), array('title'=>'Deactivate', 'style'=>'color:#539D00;'));
									}else if($value['Country']['status']==2){
										echo $this->Html->link(Configure::read('Status.' . $value['Country']['status']), array('action'=>'status',$value['Country']['id']), array('title'=>'Activate', 'style'=>'color:#FF3D28;'));
									} ?>
								</td>
								<td>									
									<div class="btn-group">
										<button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown">Action <span class="caret"></span></button>
										<ul class="dropdown-menu dropdown-menu-new" role="menu">
											<li><?php echo $this->Html->link('<i class="fa fa-pencil"></i> Edit', array('controller'=>'countries', 'action'=>'edit', $value['Country']['id']), array('escape'=>false)); ?></li>
											<li><?php echo $this->Html->link('<i class="fa fa-trash-o"></i> Delete', "#myModal2_". $value['Country']['id'], array('data-toggle'=>'modal', 'escape'=>false)); ?></li>
										</ul>
									</div>
								</td>
							</tr>
							
							<div class="modal fade" id="myModal2_<?php echo $value['Country']['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h3 class="modal-title">Delete!!</h3>
										</div>
										<div class="modal-body">Are you sure, you want to delete this record?</div>
										<div class="modal-footer">
											<button data-dismiss="modal" class="btn btn-default" type="button">Close</button><?php
											echo $this->Html->link('Confirm', array('controller'=>'countries', 'action'=>'delete', $value['Country']['id']), array('data-toggle'=>'modal', 'escape'=>false, 'class'=>'btn btn-warning')) ; ?>
										</div>
									</div>
								</div>
							</div><?php
						} ?>				  
					</tbody>
				</table><?php
				
				$this->Paginator->options(array('url' => $this->passedArgs));
				echo $this->element('Admin/admin_pagination', array("paging_model_name"=>"Country", "total_title"=>"Sale Tax Lists")); 
			}else{
				echo "<div class='no-record-found'>No Information for Display.</div>";
			} ?>
				
		</section>
	</div>
</div>