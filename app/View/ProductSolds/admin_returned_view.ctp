<div class="row">
	<div class="col-lg-12"><?php //pr($orders_product);
		echo $this->Html->link('Dashboard', array('admin'=>true, 'controller'=>'admins', 'action'=>'dashboard')) ."&nbsp;&nbsp;/&nbsp;&nbsp;";
		echo $this->Html->link("Product Sold Lists", array('admin'=>true, 'controller'=>'product_solds', 'action'=>'returned')) ."&nbsp;&nbsp;/&nbsp;&nbsp;"; 
		echo $this->Html->link($title_for_layout, "javascript:void(0);"); ?>
	</div> 
</div>

<div class="row">
	<div class="col-lg-12">
		<h3 class="page-title"><?php
			echo $title_for_layout; ?> 
		</h3>
	</div>
</div>
 
<!-- invoice start-->
<section>
	
	<div class="panel panel-primary">
		<div class="panel-body">
			<div class="row invoice-list">

				<div class="col-lg-4 col-sm-4">
					<h4>INVOICE INFO</h4>
					<table width="100%">
						<tr>
							<td>Invoice Number</td>
							<td>: <strong><?php echo $data['ProductSold']['order_sku']; ?></strong></td>
						</tr>
						
						<tr>
							<td>Invoice Status</td>
							<td>: <?php echo (Configure::read('SalesStatus.'. $data['ProductSold']['status']));?></td>
						</tr>
					
						<tr>
							<td>Ordered Date</td>
							<td>: <?php echo date('F d, Y H:i', strtotime($data['ProductSold']['created']));?></td>
						</tr><?php
						
						if($data['ProductSold']['packed_date']){ ?>
							<tr>
								<td>Packed Date</td>
								<td>: <?php echo date('F d, Y H:i', strtotime($data['ProductSold']['packed_date']));?></td>
							</tr><?php
						} 
						
						if($data['ProductSold']['dispached_date']){ ?>
							<tr>
								<td>Dispached Date</td>
								<td>: <?php echo date('F d, Y H:i', strtotime($data['ProductSold']['dispached_date']));?></td>
							</tr><?php
						} 
						
						if($data['ProductSold']['delivered_date']){ ?>
							<tr>
								<td>Delivered Date</td>
								<td>: <?php echo date('F d, Y H:i', strtotime($data['ProductSold']['delivered_date']));?></td>
							</tr><?php
						} 
						
						if($data['ProductSold']['canceled_date']){ ?>
							<tr>
								<td>Canceled Date</td>
								<td>: <?php echo date('F d, Y H:i', strtotime($data['ProductSold']['canceled_date']));?></td>
							</tr><?php
						}
						
						if($data['ProductSold']['returned_date']){ ?>
							<tr>
								<td>Returned Date</td>
								<td>: <?php echo date('F d, Y H:i', strtotime($data['ProductSold']['returned_date']));?></td>
							</tr><?php
						} ?>
						
					</table>
				</div>
				
				<div class="col-lg-4 col-sm-4">&nbsp;</div>
				
				<div class="col-lg-4 col-sm-4">
					<h4>SHIPPING ADDRESS</h4>
					<p><?php
						echo $data['User']['address'] .'<br>';
						echo $data['User']['city'] .', '. $data['User']['state'] .' - '. $data['User']['zip_code'] .'<br>'; 
						
						if($data['User']['country_id']){
							echo $this->General->getCountryName($data['User']['country_id']) .'<br>';
						} 
						echo "<br>";
						
						if($data['User']['username']){
							echo "Email Address: ". $data['User']['username'] .'<br>';
						} 
						
						if($data['User']['phone']){
							echo "Phone#: ". $data['User']['phone'] .'<br>';
						} 
						
						if($data['User']['mobile']){
							echo "Mobile#: ". $data['User']['mobile'] .'<br>';
						}
						
						if($data['User']['fax']){
							echo "Fax#: ". $data['User']['fax'] .'<br>';
						}  ?>
					</p>
				</div>
			</div>
			
			<table class="table table-striped table-hover">
			
				<thead>
					<tr>
						<th>#</th>
						<th>Item</th>
						<th class="hidden-phone">Description</th>
						<th class="">Unit Cost</th>
						<th class="">Quantity</th>
						<th>Total</th>
					</tr>
				</thead>

				<tbody><?php
					if($orders_product){ 
						$i = 1;
						foreach($orders_product as $val){ ?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $val['Product']['product_sku'] .' - '. $val['Product']['title']; ?></td>
								<td class="hidden-phone"><?php 
									$desc = trim($val['Product']['description']); 
									echo (strlen($desc) > 70)?substr($desc, 0, 70) .'....':$desc; ?>
								</td>
								<td class="">$<?php echo $val['ProductSalesorder']['selling_price']; ?></td>
								<td class=""><?php echo $val['ProductSalesorder']['quantity']; ?></td>
								<td>$<?php echo $val['ProductSalesorder']['total_selling_price']; ?></td>
							</tr><?php
							$i++;
						} 
					}else{ ?>
						<tr>
							<td colspan="6"><div class='no-record-found'>No records found.</div></td>
						</tr><?php
					} ?>
				</tbody>
			</table>

			<div class="row">
				<div class="col-lg-4 invoice-block pull-right">
					<ul class="unstyled amounts">
						<li><strong>Sub Total :</strong> $<?php echo $data['ProductSold']['selling_price']; ?></li>
						<li><strong>Sales Tax :</strong> <?php echo ($data['ProductSold']['taxes'])?"$". $data['ProductSold']['taxes']:'----'; ?></li>
						<li><strong>Grand Total :</strong> $<?php echo $data['ProductSold']['total_selling_price']; ?></li>
					</ul>
				</div>
			</div>

			<div class="text-center invoice-btn">
				<a onclick="javascript:;" class="btn btn-info btn-lg"><i class="fa fa-print"></i> Download Invoice </a>
			</div>
		</div>
	</div>
</section>
<!-- invoice end-->