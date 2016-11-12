<ol class="breadcrumb">
	<li class=""><?php echo $this->Html->link('Dashboard', array('admin'=>true, 'controller'=>'admins', 'action'=>'dashboard')); ?></li>
	<li class=""><?php echo $this->Html->link('Sales Order Lists', array('admin'=>true, 'controller'=>'sales', 'action'=>'index')); ?></li>
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
											<td>Sales Order#</td>
											<td><?php echo ($data['Sale']['order_no'])?$data['Sale']['order_no']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Reference#</td>
											<td><?php echo ($data['Sale']['reference'])?$data['Sale']['reference']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Sales Order Date</td>
											<td><?php echo ($data['Sale']['order_date'])?$data['Sale']['order_date']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Expected Shipping Date</td>
											<td><?php echo ($data['Sale']['expected_shipping_date'])?$data['Sale']['expected_shipping_date']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Delivery Method</td>
											<td><?php echo ($data['Sale']['delivery_method'])?$data['Sale']['delivery_method']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Sales Person</td>
											<td><?php echo ($data['Sale']['sales_person'])?$data['Sale']['sales_person']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Customer Notes</td>
											<td><?php echo ($data['Sale']['cust_note'])?$data['Sale']['cust_note']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Term and Conditions</td>
											<td><?php echo ($data['Sale']['term_condition'])?$data['Sale']['term_condition']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Email To</td>
											<td><?php echo ($data['Sale']['email_to'])?$data['Sale']['email_to']:'------'; ?></td>
										</tr><?php 
										
										if($data['Sale']['packed_date']) { ?>
											<tr>
												<td style="width:20%;">Packed Date</td>
												<td><?php echo date('F d, Y H:i', strtotime($data['Sale']['packed_date']));?></td>
											</tr> <?php 
										}  
										
										if($data['Sale']['dispached_date']) { ?>
											<tr>
												<td style="width:20%;">Dispached Date</td>
												<td><?php echo date('F d, Y H:i', strtotime($data['Sale']['dispached_date']));?></td>
											</tr><?php  
										}
										
										if($data['Sale']['delivered_date']) { ?>
											<tr>
												<td style="width:20%;">Delivered Date</td>
													<td><?php echo date('F d, Y H:i', strtotime($data['Sale']['delivered_date']));?></td>
												</tr> <?php 
										}
										
										if($data['Sale']['canceled_date']) { ?>
											<tr>
												<td style="width:20%;">Canceled Date</td>
													<td><?php echo date('F d, Y H:i', strtotime($data['Sale']['canceled_date']));?></td>
											</tr> <?php 
										}  
										
										if($data['Sale']['returned_date']) { ?>
											<tr>
												<td style="width:20%;">Returned Date</td>
												<td><?php echo date('F d, Y H:i', strtotime($data['Sale']['returned_date']));?></td>
											</tr><?php  
										} ?>  
										
										<tr>
											<td>Status</td>
											<td><?php echo (Configure::read('SalesStatus.'. $data['Sale']['status']));?></td>
										</tr>
										
										<tr>
											<td>Registered on</td>
											<td><?php echo date('F d, Y H:i', strtotime($data['Sale']['created']));?></td>
										</tr>
										
										<tr>
											<td>Last Updated on</td>
											<td><?php echo date('F d, Y H:i', strtotime($data['Sale']['modified']));?></td>
										</tr> 
										
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
								$productList = $this->General->getProductList($data['Sale']['id']);
								if(!empty($productList)) {
									foreach($productList as $value){ 
									$product_name = $value['Product']['sku'] .': '. $value['Product']['name'];  ?>
									<tr>
										<td><?php echo $product_name; ?></td>
										<td><?php echo $value['SaleProduct']['qty']; ?></td>
										<td><?php echo $value['SaleProduct']['rate']; ?></td>
										<td><?php echo $value['SaleProduct']['discount']; ?></td>
										<td><?php echo $value['SaleProduct']['tax']; ?></td>
										<td><?php echo $value['SaleProduct']['total_amount']; ?></td>
										</tr><?php							
									}
								} else { ?>
								<tr>
									<td colspan="6">No recode found.</td>
									</tr><?php
								} ?>
								
								<tr>
									<td colspan="2"><?php
									echo $this->Html->link("<i class='fa fa-caret-square-o-left'></i> Back", array('admin'=>true, 'controller'=>'sales', 'action'=>'index'), array("class"=>"btn btn-default", "escape"=>false)); ?>
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