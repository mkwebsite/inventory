<ol class="breadcrumb">
	<li class=""><?php echo $this->Html->link('Dashboard', array('admin'=>true, 'controller'=>'admins', 'action'=>'dashboard')); ?></li>
	<li class=""><?php echo $this->Html->link('Purchase Order Lists', array('admin'=>true, 'controller'=>'purchases', 'action'=>'index')); ?></li>
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
											<td style="width:24%; border:0;">Vendor Name</td>
											<td style="border:0;"><?php echo $data['User']['first_name'].' '.$data['User']['last_name']; ?></td>
										</tr>
										
										<tr>
											<td>Purchases Order#</td>
											<td><?php echo ($data['Purchase']['order_no'])?$data['Purchase']['order_no']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Reference#</td>
											<td><?php echo ($data['Purchase']['reference'])?$data['Purchase']['reference']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Date</td>
											<td><?php echo ($data['Purchase']['date'])?$data['Purchase']['date']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Expected Delivery Date</td>
											<td><?php echo ($data['Purchase']['expected_delivery_date'])?$data['Purchase']['expected_delivery_date']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Item Rates Are</td>
											<td><?php echo ($data['Purchase']['item_rates_are']==1)?'Tax Exclusive':'Tax Inclusive'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Shipment Preference</td>
											<td><?php echo ($data['Purchase']['shipment_preference'])?$data['Purchase']['shipment_preference']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Notes</td>
											<td><?php echo ($data['Purchase']['cust_note'])?$data['Purchase']['cust_note']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Deliver To</td><?php
											$customer_user_data = $this->General->getDeliverTo($data['Purchase']['deliver_to']);
											$first_name = isset($customer_user_data['User']['first_name'])?$customer_user_data['User']['first_name']:'';
											$last_name = isset($customer_user_data['User']['last_name'])?$customer_user_data['User']['last_name']:'';
											$customer_name = $first_name.' '.$last_name; 
											$address_user = $this->General->getUseraddress($data['Purchase']['deliver_to']);
											$street = isset($address_user['UserBillingAddress']['street'])?$address_user['UserBillingAddress']['street'].', ':'';
											$city = isset($address_user['UserBillingAddress']['city'])?$address_user['UserBillingAddress']['city'].', ':'';
											$state = isset($address_user['UserBillingAddress']['state'])?$address_user['UserBillingAddress']['state'].', ':'';
											$zip_code = isset($address_user['UserBillingAddress']['zip_code'])?$address_user['UserBillingAddress']['zip_code'].', ':'';
											$country = isset($address_user['UserBillingAddress']['country'])?$address_user['UserBillingAddress']['country'].', ':'';
											$phone = isset($address_user['UserBillingAddress']['phone'])?$address_user['UserBillingAddress']['phone']:'';

											$full_address = $street.$city.$state.$country.$zip_code.$phone; 
											
											?>
											<td><?php echo $customer_name.', Address:'.$full_address; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Term and Conditions</td>
											<td><?php echo ($data['Purchase']['term_condition'])?$data['Purchase']['term_condition']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">Email To</td>
											<td><?php echo ($data['Purchase']['email_to'])?$data['Purchase']['email_to']:'------'; ?></td>
										</tr><?php 
										
										if($data['Purchase']['packed_date']) { ?>
											<tr>
												<td style="width:20%;">Packed Date</td>
												<td><?php echo date('F d, Y H:i', strtotime($data['Purchase']['packed_date']));?></td>
											</tr> <?php 
										}  
										
										if($data['Purchase']['dispached_date']) { ?>
											<tr>
												<td style="width:20%;">Dispached Date</td>
												<td><?php echo date('F d, Y H:i', strtotime($data['Purchase']['dispached_date']));?></td>
											</tr><?php  
										}
										
										if($data['Purchase']['delivered_date']) { ?>
											<tr>
												<td style="width:20%;">Delivered Date</td>
													<td><?php echo date('F d, Y H:i', strtotime($data['Purchase']['delivered_date']));?></td>
												</tr> <?php 
										}
										
										if($data['Purchase']['canceled_date']) { ?>
											<tr>
												<td style="width:20%;">Canceled Date</td>
													<td><?php echo date('F d, Y H:i', strtotime($data['Purchase']['canceled_date']));?></td>
											</tr> <?php 
										}  
										
										if($data['Purchase']['returned_date']) { ?>
											<tr>
												<td style="width:20%;">Returned Date</td>
												<td><?php echo date('F d, Y H:i', strtotime($data['Purchase']['returned_date']));?></td>
											</tr><?php  
										} ?>  
										
										<tr>
											<td>Status</td>
											<td><?php echo (Configure::read('SalesStatus.'. $data['Purchase']['status']));?></td>
										</tr>
										
										<tr>
											<td>Registered on</td>
											<td><?php echo date('F d, Y H:i', strtotime($data['Purchase']['created']));?></td>
										</tr>
										
										<tr>
											<td>Last Updated on</td>
											<td><?php echo date('F d, Y H:i', strtotime($data['Purchase']['modified']));?></td>
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
								$productList = $this->General->getPurchasesList($data['Purchase']['id']);
								if(!empty($productList)) {
									foreach($productList as $value){ 
									$product_name = $value['Product']['sku'] .': '. $value['Product']['name'];  ?>
									<tr>
										<td><?php echo $product_name; ?></td>
										<td><?php echo $value['PurchaseProduct']['qty']; ?></td>
										<td><?php echo $value['PurchaseProduct']['rate']; ?></td>
										<td><?php echo $value['PurchaseProduct']['discount']; ?></td>
										<td><?php echo $value['PurchaseProduct']['tax']; ?></td>
										<td><?php echo $value['PurchaseProduct']['total_amount']; ?></td>
										</tr><?php							
									}
								} else { ?>
								<tr>
									<td colspan="6">No recode found.</td>
									</tr><?php
								} ?>
								
								<tr>
									<td colspan="2"><?php
									echo $this->Html->link("<i class='fa fa-caret-square-o-left'></i> Back", array('admin'=>true, 'controller'=>'purchases', 'action'=>'index'), array("class"=>"btn btn-default", "escape"=>false)); ?>
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