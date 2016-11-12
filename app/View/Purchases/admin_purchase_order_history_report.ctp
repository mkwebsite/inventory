<?php
	//pr($data); die;
	$pageCount = (isset($this->params['paging']['Purchase']['pageCount']) and $this->params['paging']['Purchase']['pageCount'])?$this->params['paging']['Purchase']['pageCount']:0;
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
	<li class=""><?php echo $this->Html->link('Reports', array('admin'=>true, 'controller'=>'purchases', 'action'=>'report')); ?></li>
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
	 

		<div class="row margin_btm10">
			<div class="col-lg-12">
				<div class="btn-group btn-group-justified">
					 </div>
			</div> 
		</div>

		<div class="row">
			<div class="col-lg-12">
				<section class="panel">
					<div class="panel-heading">
						<h2>Search</h2> 
						<div class="options" style="float: right;">
						<?php
						echo $this->Html->link('<i class="fa fa-print"></i>&nbsp;Print',"javascript:void(0);", array('onclick'=>"PrintElem('#mydiv')", 'escape'=>false, 'class'=>'btn-sm btn-inverse')).'&nbsp';
						echo $this->Html->link('Export PDF', array('controller'=>'purchases', 'action'=>'export_pdf'), array('escape'=>false, 'class'=>'btn-sm btn-inverse')).'&nbsp';
						echo $this->Html->link('Export CSV', array('controller'=>'purchases', 'action'=>'export_csv'), array('escape'=>false, 'class'=>'btn-sm btn-inverse')).'&nbsp';
						echo $this->Html->link('Export XLS', array('controller'=>'purchases', 'action'=>'export_xls'), array('escape'=>false, 'class'=>'btn-sm btn-inverse'));
						?>
						</div>
					</div> 
					
					<div class="panel-body"><?php
						echo $this->Form->create('Purchase', array(
							'url'=>array('controller'=>'purchases', 'action'=>'purchase_order_history_report'), 
							'class'=>'form-inline', 'role'=>'form'
						)); 
						
							$to  = $this->Session->read('AdminSearch.to');
							$from  = $this->Session->read('AdminSearch.from');
							$status  = $this->Session->read('AdminSearch.status');
							
							?>
						
							<div class="form-group" style="width:20%;">
								<label class="sr-only" for="UserFirstName">From</label><?php
								echo $this->Form->input('from', array('type'=>'text', 'placeholder'=>'From', 'div'=>false, "class"=>"form-control datepicker", 'value'=>$from, 'label'=>false, 'style'=>'width:100%')); ?>
							</div>&nbsp;
							
							<div class="form-group" style="width:20%;">
								<label class="sr-only" for="UserFirstName">To</label><?php
								echo $this->Form->input('to', array('type'=>'text', 'placeholder'=>'To', 'div'=>false, "class"=>"form-control datepicker", 'value'=>$to, 'label'=>false, 'style'=>'width:100%')); ?>
							</div>&nbsp;
							
							<div class="form-group" style="width:20%;">
								<label class="sr-only" for="UserFirstName">Status</label><?php
								echo $this->Form->input('status', array('empty'=>'Sales Status','options'=>Configure::read('PurchasesStatus'), 'div'=>false, "class"=>"form-control", 'value'=>$status, 'label'=>false, 'style'=>'width:100%')); ?>
							</div>&nbsp; 
							
							<?php
						
							echo $this->Form->submit("Search", array("class"=>"btn btn-info", 'div'=>false)); echo "&nbsp;";
							echo $this->Html->link('Show All', array('controller'=>'purchases', 'action'=>'purchase_order_history_report'), array('escape'=>false, 'class'=>'btn btn-info'));
							
						echo $this->Form->end(); ?>
					</div>
				</section>
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
						<div id="mydiv">
						<table class="table m-n">
							<thead>
								<tr>
									<th class="sorting<?php echo ($sort_by=='date')?'_'.$asc_desc:''; ?> "><span class="m7"><?php echo $this->ExPaginator->sort('Purchase.order_date', 'Date'); ?> </span></th>
									<th class="sorting<?php echo ($sort_by=='order_no')?'_'.$asc_desc:''; ?> "><span class="m7"><?php echo $this->ExPaginator->sort('Purchase.order_no', 'Purchases Order#'); ?> </span></th>
									<th class="sorting<?php echo ($sort_by=='first_name')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('Purchase.first_name', 'Vendor Name'); ?> </span></th>
									<th class="hidden-phone sorting<?php echo ($sort_by=='reference')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('User.reference', 'Reference#'); ?> </span></th> 
									<th class="sorting<?php echo ($sort_by=='status')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('Purchase.status', 'Status'); ?> </span></th>
									<th class="sorting<?php echo ($sort_by=='status')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('Purchase.expected_delivery_date', 'Expected Date'); ?> </span></th>
									<th>Qty Ordered</th>
									<th>Amount</th>
				 					<?php /*<th class="sorting<?php echo ($sort_by=='total_amount')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('Purchase.total_amount', 'Amount'); ?> </span></th>*/ ?>
								</tr>
							</thead>
							
							<tbody><?php
								$total_amount = 0;
								$all_total_qty = 0;
								$all_total_amt = 0;
								foreach($data as $value){ ?>
									<tr>
										<td><?php echo $this->Html->link(date('M d, Y', strtotime($value['Purchase']['date'])), array('controller'=>'purchases', 'action'=>'view', $value['Purchase']['id'])); ?></td>
										<td><?php echo $this->Html->link($value['Purchase']['order_no'], array('controller'=>'purchases', 'action'=>'view', $value['Purchase']['id'])); ?></td>
										<td class="hidden-phone"><?php echo $value['User']['first_name'] .' '. $value['User']['last_name']; ?></td> 
										<td><?php echo $this->Html->link($value['Purchase']['reference'], array('controller'=>'purchases', 'action'=>'view', $value['Purchase']['id'])); ?></td>
										
										<td><?php
											if($value['Purchase']['status']==1){
												echo $this->Html->link(Configure::read('SalesStatus.' . $value['Purchase']['status']), array('action'=>'status',$value['Purchase']['id']), array('title'=>'Packed', 'style'=>'color:#539D00;'));
											}else{
												echo $this->Html->link(Configure::read('SalesStatus.' . $value['Purchase']['status']), array('action'=>'status',$value['Purchase']['id']), array('title'=>'New Order', 'style'=>'color:#FF3D28;'));
											} ?>
										</td>
										<td> <?php echo date('M d, Y', strtotime($value['Purchase']['expected_delivery_date'])); ?></td> 
										<?php
										$total_amount = $this->General->getPurchaseTotalAmount($value['Purchase']['id']); 
										$total_qty = $this->General->getPurchaseTotalQty($value['Purchase']['id']);
										$all_total_qty += $total_qty;  
										$all_total_amt += $total_amount; ?>
										<td><?php echo $total_qty; ?></td> 
										<td><?php echo number_format($total_amount,2); ?></td>  
								 	</tr>
									  <?php
								} ?>	
								<tr><td colspan="6">Total</td><td><?php echo $all_total_qty; ?></td><td>$<?php echo number_format($all_total_amt,2); ?></td></tr>
							</tbody>
						</table>
						</div><?php
						
						$this->Paginator->options(array('url' => $this->passedArgs));
						echo $this->element('Admin/admin_pagination', array("paging_model_name"=>"Purchase", "total_title"=>"Purchase Lists")); 
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
	
    $(function() {
		$( ".datepicker" ).datepicker({
			dateFormat: 'yy-mm-dd', 
			changeMonth: true,
			changeYear: true,
            yearRange : 'c-1:c+5'
		});		
    });	
	 
	  
    function PrintElem(elem) {
        Popup($(elem).html());
    }

    function Popup(data) {
		
        var mywindow = window.open('', 'Sales Report', 'height=400,width=1000');
        mywindow.document.write('<html><head><title>Sales Report</title>'); 
		mywindow.document.write('<link rel="stylesheet" type="text/css" href="<?= Configure::read("App.SiteUrl"); ?>/assets/css/styles.css" />');
		mywindow.document.write('<link rel="stylesheet" type="text/css" href="<?= Configure::read("App.SiteUrl"); ?>/assets/fonts/font-awesome/css/font-awesome.min.css" />');
		mywindow.document.write('<link rel="stylesheet" type="text/css" href="<?= Configure::read("App.SiteUrl"); ?>/assets/fonts/themify-icons/themify-icons.css" />');
		mywindow.document.write('<link rel="stylesheet" type="text/css" href="<?= Configure::read("App.SiteUrl"); ?>/assets/plugins/codeprettifier/prettify.css" />');
		mywindow.document.write('<link rel="stylesheet" type="text/css" href="<?= Configure::read("App.SiteUrl"); ?>/assets/plugins/iCheck/skins/minimal/blue.css" />');
		mywindow.document.write('<link rel="stylesheet" type="text/css" href="<?= Configure::read("App.SiteUrl"); ?>/assets/plugins/fullcalendar/fullcalendar.css" />');
		mywindow.document.write('<link rel="stylesheet" type="text/css" href="<?= Configure::read("App.SiteUrl"); ?>/assets/plugins/switchery/switchery.css" />');
		mywindow.document.write('</head><body ><div class="static-content"><div class="page-content"><div class="container-fluid"><div class="ui-sortable"><div class="row"><div class="col-lg-12"><section class="panel">');
        mywindow.document.write(data);
        mywindow.document.write('</section></div></div></div></div></div></div></body></html>'); 
        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10
        mywindow.print();
        mywindow.close();

        return true;
    }  
	
    $(function() {
		$( ".datepicker" ).datepicker({
			dateFormat: 'yy-mm-dd', 
			changeMonth: true,
			changeYear: true,
            yearRange : 'c-1:c+5'
		});		
    });	
</script>	
	 