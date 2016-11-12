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
	<div class="col-lg-8">
		<h3 class="page-title margin_top0"><?php echo $title_for_layout; ?></h3>
	</div>
	<div class="col-lg-4">
		<div class="btn-group btn-group-justified"><?php
			echo $this->Html->link($canceled .' Canceled', array('controller'=>'product_solds', 'action'=>'returned', 5), array("class"=>"btn btn-danger"));
			echo $this->Html->link($returned .' Returned', array('controller'=>'product_solds', 'action'=>'returned', 6), array("class"=>"btn btn-warning"));
			echo $this->Html->link($all .' All', array('controller'=>'product_solds', 'action'=>'returned'), array("class"=>"btn btn-info")); ?>
		</div>
	</div> 
</div>

<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">Search</header>
			
			<div class="panel-body"><?php
				$status = (isset($this->params['pass'][0]))?$this->params['pass'][0]:'';
				
				echo $this->Form->create('ProductSold', array(
					'url'=>array('controller'=>'product_solds', 'action'=>'returned', $status), 
					'class'=>'form-inline', 'role'=>'form'
				)); 
				
					$keywords  = $this->Session->read('AdminSearch'); ?>
				
					<div class="form-group">
						<label class="sr-only" for="UserFirstName">Search Keyword</label><?php
						echo $this->Form->input('keyword', array('type'=>'text', 'placeholder'=>'Search Keyword', 'div'=>false, "class"=>"form-control", 'value'=>$keywords, 'label'=>false)); ?>
					</div>&nbsp;<?php
				
					echo $this->Form->submit("Search", array("class"=>"btn btn-success", 'div'=>false)); echo "&nbsp;";
					echo $this->Html->link('Show All', array('controller'=>'product_solds', 'action'=>'returned'), array('escape'=>false, 'class'=>'btn btn-success'));
					
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
							<th class="sorting<?php echo ($sort_by=='order_sku')?'_'.$asc_desc:''; ?> "><span class="m7"><?php echo $this->ExPaginator->sort('ProductSold.order_sku', 'Order SKU'); ?> </span></th>
							<th class="hidden-phone sorting<?php echo ($sort_by=='first_name')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('User.first_name', 'Customer'); ?> </span></th>
							<th class="sorting<?php echo ($sort_by=='selling_price')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('ProductSold.selling_price', 'Selling Price'); ?> </span></th>
							<th class="hidden-phone sorting<?php echo ($sort_by=='quantity')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('ProductSold.quantity', 'Quantity'); ?> </span></th>
							<th class="sorting<?php echo ($sort_by=='created')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('ProductSold.created', 'Order Date'); ?> </span></th>
							<th class="sorting<?php echo ($sort_by=='status')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('ProductSold.status', 'Status'); ?> </span></th>
							<th class="actionW">Action</th>
						</tr>
					</thead>
					
					<tbody><?php
						foreach($data as $value){ ?>
							<tr>
								<td><?php echo $this->Html->link($value['ProductSold']['order_sku'], array('controller'=>'product_solds', 'action'=>'returned_view', $value['ProductSold']['id'])); ?></td>
								<td class="hidden-phone"><?php echo $value['User']['first_name'] .' '. $value['User']['last_name']; ?></td>
								<td class="hidden-phone">$<?php echo $value['ProductSold']['selling_price']; ?></td>
								<td class="hidden-phone"><?php echo $value['ProductSold']['quantity']; ?></td>
								<td class="hidden-phone"><?php echo date('F d, Y', strtotime($value['ProductSold']['created'])); ?></td>
								<td><?php
									echo $this->Html->link(Configure::read('SalesStatus.' . $value['ProductSold']['status']), "javascript:void(0);", array('style'=>'color:#539D00;'));  ?>
								</td>
								<td><?php 
									echo $this->Html->link('<i class="fa fa-credit-card"></i>', array('controller'=>'product_solds', 'action'=>'returned_view', $value['ProductSold']['id']), array('escape'=>false)); ?></li>
								</td>
							</tr><?php
						} ?>				  
					</tbody>
				</table><?php
				
				$this->Paginator->options(array('url' => $this->passedArgs));
				echo $this->element('Admin/admin_pagination', array("paging_model_name"=>"ProductSold", "total_title"=>"Product Lists")); 
			}else{
				echo "<div class='no-record-found'>No Information for Display.</div>";
			} ?>
				
		</section>
	</div>
</div>