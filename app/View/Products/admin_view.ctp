<ol class="breadcrumb">
	<li><?php echo $this->Html->link('Dashboard', array('admin'=>true, 'controller'=>'admins', 'action'=>'dashboard')); ?></li>
	<li><?php echo $this->Html->link("Product Lists", array('admin'=>true, 'controller'=>'users', 'action'=>'index')); ?></li>
	<li><?php echo $this->Html->link($title_for_layout, "javascript:void(0);"); ?></li> 
</ol> 

<div class="container-fluid">   
	<div data-widget-group="group1">  


		<div class="row">
			<div class="col-lg-12">
				<h3 class="page-title"><?php
					echo $title_for_layout; ?> 
				</h3>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
			
				<section class="panel panel-info">
					<header class="panel-heading tab-bg padding0">
						<ul class="nav nav-tabs nav-justified tabingcls">
							<li class="active">
								<a data-toggle="tab" href="#tab1">General Information</a>
							</li>
							
							<li class="">
								<a data-toggle="tab" href="#tab2">Sales Information</a>
							</li>
							
							<li class="">
								<a data-toggle="tab" href="#tab3">Purchase Information</a>
							</li>
						
							<li class="">
								<a data-toggle="tab" href="#tab4">Track Inventory for this Product</a>
							</li>
							<li class="">
								<a data-toggle="tab" href="#tab5">Bar Code</a>
							</li>
						</ul>
					</header>

					<div class="panel-body padding0">
						<div class="tab-content tasi-tab">
							<div id="tab1" class="tab-pane padding0 active">
								<table class="table table-hover">
									<tbody>
										<tr>
											<td style="width:24%; border:0;">Name</td>
											<td style="border:0;"><?php echo $data['Product']['name']; ?></td>
										</tr>
											
										<tr>
											<td>SKU</td>
											<td><?php echo ($data['Product']['sku'])?$data['Product']['sku']:'------'; ?></td>
										</tr>
										
										<tr>
											<td style="width:20%;">UOM</td>
											<td><?php echo ($data['Product']['uom'])?$data['Product']['uom']:'------'; ?></td>
										</tr>
											
										<tr>
											<td style="width:20%;">UPC</td>
											<td><?php echo ($data['Product']['upc'])?$data['Product']['upc']:'------'; ?></td>
										</tr>
											
										<tr>
											<td style="width:20%;">MPN</td>
											<td><?php echo ($data['Product']['mpn'])?$data['Product']['mpn']:'------'; ?></td>
										</tr>
											
										<tr>
											<td style="width:20%;">EAN</td>
											<td><?php echo ($data['Product']['ean'])?$data['Product']['ean']:'------'; ?></td>
										</tr> 
										<tr>
											<td style="width:20%;">ISBN</td>
											<td><?php echo ($data['Product']['isbn'])?$data['Product']['isbn']:'------'; ?></td>
										</tr> 
										
										<tr>
											<td>Status</td>
											<td><?php echo (Configure::read('Status.'. $data['Product']['status']));?></td>
										</tr>
										
										<tr>
											<td>Registered on</td>
											<td><?php echo date('F d, Y H:i', strtotime($data['Product']['created']));?></td>
										</tr>
										
										<tr>
											<td>Last Updated on</td>
											<td><?php echo date('F d, Y H:i', strtotime($data['Product']['modified']));?></td>
										</tr>
										
										<tr>
											<td colspan="2"><?php
												echo $this->Html->link("<i class='fa fa-caret-square-o-left'></i> Back", array('admin'=>true, 'controller'=>'products', 'action'=>'index'), array("class"=>"btn btn-default", "escape"=>false)); ?>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						  
							<div id="tab2" class="tab-pane padding0">
								
								<table class="table table-hover">
									<tbody>
										<tr>
											<td style="width:20%; border:0;">Selling Price</td>
											<td style="border:0;"><?php echo ($data['Product']['selling_price'])?"$". $data['Product']['selling_price']:'------'; ?></td>
										</tr>
											
										<tr>
											<td style="width:20%;">Account</td>
											<td><?php echo ($data['Product']['sales_account'])?Configure::read('SalesAccount.'. $data['Product']['sales_account']):'------'; ?></td>
										</tr> 
											
										<tr>
											<td style="width:20%;">Description</td>
											<td><?php echo ($data['Product']['sales_desc'])?$data['Product']['sales_desc']:'------'; ?></td>
										</tr> 
											
										<tr>
											<td style="width:20%;">Sales Tax</td>
											<td><?php echo ($data['Product']['sales_tax'])?$data['Product']['sales_tax']:'------'; ?></td>
										</tr>  
										
										<tr>
											<td colspan="2"><?php
												echo $this->Html->link("<i class='fa fa-caret-square-o-left'></i> Back", array('admin'=>true, 'controller'=>'products', 'action'=>'index'), array("class"=>"btn btn-default", "escape"=>false)); ?>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						  
							<div id="tab3" class="tab-pane padding0">						
								<table class="table table-hover">
									<tbody>
										<tr>
											<td style="width:20%; border:0;">Cost Price</td>
											<td style="border:0;"><?php echo ($data['Product']['cost_price'])?"$". $data['Product']['cost_price']:'------'; ?></td>
										</tr>
											
										<tr>
											<td style="width:20%;">Account</td>
											<td><?php echo ($data['Product']['purchase_account'])?Configure::read('PurchasesAccount.'. $data['Product']['purchase_account']):'------'; ?></td>
										</tr> 
											
										<tr>
											<td style="width:20%;">Description</td>
											<td><?php echo ($data['Product']['purchase_desc'])?$data['Product']['purchase_desc']:'------'; ?></td>
										</tr> 
										
										<tr>
											<td colspan="2"><?php
												echo $this->Html->link("<i class='fa fa-caret-square-o-left'></i> Back", array('admin'=>true, 'controller'=>'products', 'action'=>'index'), array("class"=>"btn btn-default", "escape"=>false)); ?>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						
							<div id="tab4" class="tab-pane padding0">						
								<table class="table table-hover">
									<tbody>
										<tr>
											<td style="width:20%; border:0;">Account</td>
											<td style="border:0;"><?php echo ($data['Product']['track_account'])?Configure::read('TrackAccount.'. $data['Product']['track_account']):'------'; ?></td>
										</tr>
											
										<tr>
											<td style="width:20%;">Initial Stock</td>
											<td><?php echo ($data['Product']['initial_stock'])?$data['Product']['initial_stock']:'------'; ?></td>
										</tr> 
											
										<tr>
											<td style="width:20%;">Preferred Vendor</td>
											<td><?php echo ($data['User']['first_name'])?$data['User']['first_name'] .' '. $data['User']['last_name']:'------'; ?></td>
										</tr> 
											
										<tr>
											<td style="width:20%;">Reorder Level</td>
											<td><?php echo ($data['Product']['reorder_level'])?$data['Product']['reorder_level']:'------'; ?></td>
										</tr>  
										
										<tr>
											<td colspan="2"><?php
												echo $this->Html->link("<i class='fa fa-caret-square-o-left'></i> Back", array('admin'=>true, 'controller'=>'products', 'action'=>'index'), array("class"=>"btn btn-default", "escape"=>false)); ?>
											</td>
										</tr>
									</tbody>
								</table>
							</div>

							<div id="tab5" class="tab-pane padding0">						
								<table class="table table-hover">
									<tbody>
										<?php if($data['Product']['barcode_genrated'] == 1) { ?>
										<tr>
											<td style="width:20%; border:0;">BarCode</td>
											<td style="border:0;">
                                         <?php 
                                         $imgname = 'product_'.$data['Product']['id'].'.png';
                                         echo $this->Html->image('/uploads/products/barcode/'.$imgname, array('alt' => 'BarCode','id'=>'BarcodeImage')); ?></td>
										</tr>
												<?php } else { ?>
												<img src="" id="BarcodeImage" alt="BarCode" >
												<?php } ?>
										
										<tr>
											<td colspan="2"><?php
											if($data['Product']['barcode_genrated'] == 1) {
												?>
												<a id="BarcodeGenerate" class="btn btn-default" href="javascript:;" onclick="barcodeg()"><i class="fa fa-caret-square-o-left"></i>Re-Generate BarCode</a> &nbsp;

												<a id="BarcodeGenerate" class="btn btn-default" href="<?php echo Router::url('/',true);?>/admin/products/download/<?php echo $data['Product']['id']; ?>"><i class="fa fa-caret-square-o-left"></i>Download BarCode</a> 
												<?php 
												} else { 
													?>
													<a id="BarcodeGenerate" class="btn btn-default" href="javascript:;" onclick="barcodeg()"><i class="fa fa-caret-square-o-left"></i>Generate BarCode</a> 
													<?php
												} ?>

												

											</td>
										</tr>
									</tbody>
								</table>

								<script type="text/javascript">
							function barcodeg() {
								$.ajax({
								        url: "<?php echo Router::url('/',true);?>/admin/products/barcode/<?php echo $data['Product']['id']; ?>",
								        type: 'GET',                    
								        beforeSend: function () {                         
								            	$('#BarcodeImage').attr('src','');
								        },
								        success: function (data) {          
								                 res = JSON.parse(data)
								                  $('#BarcodeImage').attr('src',res.url);
								           alert(res.msg)
								           

								        }
								})
							}
						</script>
							</div> 


						</div>
					</div> 
				</section>
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
	</div>
</div>