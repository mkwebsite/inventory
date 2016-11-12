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

		<div class="row">
			<div class="col-lg-12">
				<section class="panel">
					<div class="panel-heading">
						<h2>Search</h2> 
						<div class="options" style="float: right;">
						<?php
						echo $this->Html->link('<i class="fa fa-print"></i>&nbsp;Print',"javascript:void(0);", array('onclick'=>"PrintElem('#mydiv')", 'escape'=>false, 'class'=>'btn-sm btn-inverse')).'&nbsp';
						echo $this->Html->link('Export PDF', array('controller'=>'invoices', 'action'=>'export_pdf'), array('escape'=>false, 'class'=>'btn-sm btn-inverse')).'&nbsp';
						echo $this->Html->link('Export CSV', array('controller'=>'invoices', 'action'=>'export_csv'), array('escape'=>false, 'class'=>'btn-sm btn-inverse')).'&nbsp';
						echo $this->Html->link('Export XLS', array('controller'=>'invoices', 'action'=>'export_xls'), array('escape'=>false, 'class'=>'btn-sm btn-inverse'));
						?>
						</div>
					</div> 
					
					<div class="panel-body"><?php
						echo $this->Form->create('Invoice', array(
							'url'=>array('controller'=>'invoices', 'action'=>'invoices_report'), 
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
								echo $this->Form->input('status', array('empty'=>'Invoice Status','options'=>Configure::read('Status'), 'div'=>false, "class"=>"form-control", 'value'=>$status, 'label'=>false, 'style'=>'width:100%')); ?>
							</div>&nbsp; <?php
						
							echo $this->Form->submit("Search", array("class"=>"btn btn-info", 'div'=>false)); echo "&nbsp;";
							echo $this->Html->link('Show All', array('controller'=>'invoices', 'action'=>'invoices_report'), array('escape'=>false, 'class'=>'btn btn-info'));
							
						echo $this->Form->end(); ?>
					</div>
				</section>
			</div>
		</div>

		<?php //echo $this->element('Admin/paging_counter'); ?>

		<div class="row">
			<div class="col-lg-12">
				<section class="panel" data-widget='{"draggable": "false"}'>
				
					<div class="panel-heading">
						<h2><?php echo $title_for_layout; ?></h2>
						 
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
										<th class="sorting<?php echo ($sort_by=='invoice_date')?'_'.$asc_desc:''; ?> "><span class="m7"><?php echo $this->ExPaginator->sort('Invoice.invoice_date', 'Invoice Date'); ?> </span></th>
										<th class="sorting<?php echo ($sort_by=='invoice_number')?'_'.$asc_desc:''; ?> "><span class="m7"><?php echo $this->ExPaginator->sort('Invoice.invoice_number', 'Invoice#'); ?> </span></th>
										<th class="sorting<?php echo ($sort_by=='order_number')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('User.order_number', 'Sales Number#'); ?> </span></th>
										<th class="sorting<?php echo ($sort_by=='first_name')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('Invoice.first_name', 'Customer Name'); ?> </span></th>
										<th class="sorting<?php echo ($sort_by=='status')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('Invoice.status', 'Status'); ?> </span></th>
										<th class="sorting<?php echo ($sort_by=='due_date')?'_'.$asc_desc:''; ?> "><span class="m7"><?php echo $this->ExPaginator->sort('Invoice.due_date', 'Due Date'); ?> </span></th>
										<th class="sorting">Invoice Amount</span></th>
										<?php /*<th class="sorting">Balance Due</span></th>*/ ?>
									</tr>
								</thead>
								
								<tbody><?php
									$all_total_amt = 0;
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
											<td><?php echo date('M d, Y', strtotime($value['Invoice']['due_date'])); ?></td><?php 
											$total_amount = $this->General->getTotalInvoiceAmount($value['Invoice']['id']); 
											$all_total_amt += $total_amount; ?>	
											<td class="hidden-phone">$<?php echo number_format($total_amount,2); ?></td>
										 </tr><?php
									} ?>
									<tr><td colspan="6"><b>Total</b></td><td><b>$<?php echo number_format($all_total_amt,2); ?></b></td></tr> 
								</tbody>
							</table>
						</div><?php
						
						
						$this->Paginator->options(array('url' => $this->passedArgs));
						echo $this->element('Admin/admin_pagination', array("paging_model_name"=>"Invoice", "total_title"=>"Sale Lists")); 
					}else{ ?>			
						<div class="row">
							<div class="col-lg-12">
								<div class="alert">
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