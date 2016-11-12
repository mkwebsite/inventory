<ol class="breadcrumb">
	<li class=""><?php echo $this->Html->link('Dashboard', array('admin'=>true, 'controller'=>'admins', 'action'=>'dashboard')); ?></li>
	<li class=""><?php echo $this->Html->link('Invoices', array('admin'=>true, 'controller'=>'invoices', 'action'=>'index')); ?></li>
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
					
					<div class="panel-body padding0">
						<div class="tab-content tasi-tab">
							<div id="tab1" class="tab-pane padding0 active">
								<table class="table table-hover">
									<tbody>
										<tr>
											<td style="width:24%; border:0;">Customer Name</td>
											<td style="border:0;"><?php echo $data['User']['first_name'].' '.$data['User']['last_name']; ?></td>
										</tr>
										
										<tr>
											<td>Invoice Number#</td>
											<td><?php echo ($data['Invoice']['invoice_number'])?$data['Invoice']['invoice_number']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Order Number</td>
											<td><?php echo ($data['Invoice']['order_number'])?$data['Invoice']['order_number']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Invoice Date</td>
											<td><?php echo ($data['Invoice']['invoice_date'])?$data['Invoice']['invoice_date']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Due Date</td>
											<td><?php echo ($data['Invoice']['due_date'])?$data['Invoice']['due_date']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Sales Person</td>
											<td><?php echo ($data['Invoice']['sales_person'])?$data['Invoice']['sales_person']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Customer Note</td>
											<td><?php echo ($data['Invoice']['customer_note'])?$data['Invoice']['customer_note']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Payment Options</td>
											<td><?php echo ($data['Invoice']['payment_options']==1)?'Standard':'Business';  ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Term and Conditions</td>
											<td><?php echo ($data['Invoice']['term_condition'])?$data['Invoice']['term_condition']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Email To</td>
											<td><?php echo ($data['Invoice']['email_to'])?$data['Invoice']['email_to']:'------'; ?></td>
										</tr>  
										
										<tr>
											<td>Status</td>
											<td><?php echo (Configure::read('Status.'. $data['Invoice']['status']));?></td>
										</tr>
										
										<tr>
											<td>Registered on</td>
											<td><?php echo date('F d, Y H:i', strtotime($data['Invoice']['created']));?></td>
										</tr>
										
										<tr>
											<td>Last Updated on</td>
											<td><?php echo date('F d, Y H:i', strtotime($data['Invoice']['modified']));?></td>
										</tr> 
										
										
										<?php
										$attachmentData = $this->General->getAttachment($data['Invoice']['id']);
										if(!empty($attachmentData)) { ?>
											<tr>
												 <td>Attatchments</td>
													<td><?php 
														foreach($attachmentData as $attach_val) { ?>
															<label title="Download"> 
															<?php echo $this->Html->link('<i class="fa fa-download"></i>'.$attach_val['InvoiceAttachment']['file_name'], array('controller' => 'invoices', 'action' => 'download',$attach_val['InvoiceAttachment']['id']), array('escape' => false)); ?>
															&nbsp;</label><?php 
													}?>
													</td> 
											</tr><?php 
										} ?> 

										
									</tbody>
								</table>  
								
								
							</div> 
							
						</div>
						
						
						<table class="table m-n">
							<thead>
								<tr>
									<th class="sorting"><span class="m7">Product</span></th>
									<th class="sorting"><span class="m7">Quantity</span></th>
									<th class="sorting"><span class="m7">Rate</span></th>
									<th class="sorting"><span class="m7">Discount</span></th>
									<th class="sorting"><span class="m7">Tax</span></th>
									<th class="sorting"><span class="m7">Amount</span></th>
								</tr>
							</thead>
							<tbody><?php
								$productList = $this->General->getInvoiceProduct($data['Invoice']['id']);
								if(!empty($productList)) {
									foreach($productList as $value){ 
									$product_name = $value['Product']['sku'] .': '. $value['Product']['name'];  ?>
									<tr>
										<td><?php echo $product_name; ?></td>
										<td><?php echo $value['InvoiceProduct']['qty']; ?></td>
										<td><?php echo $value['InvoiceProduct']['rate']; ?></td>
										<td><?php echo $value['InvoiceProduct']['discount']; ?></td>
										<td><?php echo $value['InvoiceProduct']['tax']; ?></td>
										<td><?php echo $value['InvoiceProduct']['total_amount']; ?></td>
										</tr><?php							
									}
								} else { ?>
								<tr>
									<td colspan="6">No recode found.</td>
									</tr><?php
								} ?>
								
								<tr>
									<td colspan="2"><?php
									echo $this->Html->link("<i class='fa fa-caret-square-o-left'></i> Back", array('admin'=>true, 'controller'=>'invoices', 'action'=>'index'), array("class"=>"btn btn-default", "escape"=>false)); ?>
									</td>
								</tr>
								
							</tbody>
						</table>
						
						
					</div> 
				</section>
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
	</div>
</div>