<div class="row">
	<div class="col-lg-12"><?php
		echo $this->Html->link('Dashboard', array('admin'=>true, 'controller'=>'admins', 'action'=>'dashboard')) ."&nbsp;&nbsp;/&nbsp;&nbsp;";
		echo $this->Html->link("Product Sold Lists", array('admin'=>true, 'controller'=>'product_solds', 'action'=>'index')) ."&nbsp;&nbsp;/&nbsp;&nbsp;"; 
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

<div class="row">
	<div class="col-lg-6">
		<section class="panel"> 
			<header class="panel-heading"><?php 
				echo ($data['ProductSold']['order_sku'] .' - '. $data['Product']['title']);?>
			</header>
				
			<table class="dataTable table table-striped table-advance table-hover">
				<tbody> 
					
					<tr>
						<td style="width:24%;">Customer Name</td>
						<td><?php echo ($data['User']['first_name'] .' '. $data['User']['first_name'])?></td>
					</tr>
					
					<tr>
						<td style="width:24%;">Vendor</td>
						<td><?php echo ($data['Vendor']['first_name'] .' '. $data['Vendor']['first_name'])?></td>
					</tr>
					
					<tr>
						<td>Title</td>
						<td><?php echo ($data['Product']['title']);?></td>
					</tr>
					
					<tr>
						<td>Product SKU</td>
						<td><?php echo ($data['Product']['product_sku']);?></td>
					</tr>
					
					<tr>
						<td>Total Selling Price</td>
						<td><?php echo ($data['ProductSold']['selling_price']?"$". $data['ProductSold']['selling_price']:'----');?></td>
					</tr>
					
					<tr>
						<td>Taxes</td>
						<td><?php echo ($data['ProductSold']['taxes']?"$". $data['ProductSold']['taxes']:'----');?></td>
					</tr>
					
					<tr>
						<td>Quantity</td>
						<td><?php echo ($data['ProductSold']['quantity']);?></td>
					</tr>
					
		            <tr>
						<td>Status</td>
						<td><?php echo (Configure::read('SalesStatus.'. $data['ProductSold']['status']));?></td>
					</tr>
					
					<tr>
						<td>Ordered Date</td>
						<td><?php echo date('F d, Y H:i', strtotime($data['ProductSold']['created']));?></td>
					</tr><?php
					
					if($data['ProductSold']['packed_date']){ ?>
						<tr>
							<td>Packed Date</td>
							<td><?php echo date('F d, Y H:i', strtotime($data['ProductSold']['packed_date']));?></td>
						</tr><?php
					} 
					
					if($data['ProductSold']['dispached_date']){ ?>
						<tr>
							<td>Dispached Date</td>
							<td><?php echo date('F d, Y H:i', strtotime($data['ProductSold']['dispached_date']));?></td>
						</tr><?php
					} 
					
					if($data['ProductSold']['delivered_date']){ ?>
						<tr>
							<td>Delivered Date</td>
							<td><?php echo date('F d, Y H:i', strtotime($data['ProductSold']['delivered_date']));?></td>
						</tr><?php
					} 
					
					if($data['ProductSold']['returned_date']){ ?>
						<tr>
							<td>Returned Date</td>
							<td><?php echo date('F d, Y H:i', strtotime($data['ProductSold']['returned_date']));?></td>
						</tr><?php
					} ?>
					
					<tr>
						<td colspan="2"><?php
							echo $this->Html->link("<i class='fa fa-caret-square-o-left'></i> Back", array('admin'=>true, 'controller'=>'product_solds', 'action'=>'index'), array("class"=>"btn btn-primary", "escape"=>false)); ?>
						</td>
					</tr>
				</tbody>
			</table>
		</section>
	</div>
	
	
	
	<div class="col-lg-6">
		<section class="panel"> 
			<header class="panel-heading">
				Shipping Address
			</header>
			
			<p style="padding:15px;"><?php
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
		</section>

		
		
		<section class="panel"> 
			<header class="panel-heading">Update Order Status</header><?php
			
			$this->request->data['ProductSold']['id'] 		= $data['ProductSold']['id'];
			$this->request->data['ProductSold']['status'] 	= (isset($this->request->data['ProductSold']['status']) and $this->request->data['ProductSold']['status'])?$this->request->data['ProductSold']['status']:$data['ProductSold']['status'];
			$this->request->data['ProductSold']['note'] 	= (isset($this->request->data['ProductSold']['note']) and $this->request->data['ProductSold']['note'])?$this->request->data['ProductSold']['note']:$data['ProductSold']['note'];
			
			echo $this->Form->create('ProductSold', 
					array('url' => array('controller' => 'product_solds', 'action' => 'view', $data['ProductSold']['id']),
					'inputDefaults' => array(
						'error' => array(
							'attributes'=>array('wrap'=>'span', 'class'=>'danger')
						)
					),
					'role'=>'form'
				));

				echo $this->Form->input('id'); ?>
				
				<table class="dataTable table table-striped table-advance table-hover">
					<tbody> 
						
						<tr>
							<td>
								<div class="form-group">
									<label class="control-label">Status</label>
									<div class="controls"><?php  
										echo $this->Form->input('status', array('options'=>Configure::read('SalesStatus'), 'div'=>false, 'label'=>false, "class" => "form-control m-wrap")); ?> 
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label">Note</label>
									<div class="controls"><?php  
										echo $this->Form->input('note', array('placeholder'=>'Note for this order', 'div'=>false, 'label'=>false, "class"=>"form-control", 'rows'=>2)); ?> 
									</div>
								</div>
								
								<div class="form-group">
									<div class="controls">
										<button type="submit" class="btn btn-primary"><i class='fa fa-check-square'></i> Update</button>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table><?php

			echo $this->Form->end(); ?>

		</section>
	</div>
	<!-- END PAGE CONTAINER-->
</div>
					