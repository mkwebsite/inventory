<div class="row">
	<div class="col-lg-12"><?php
		echo $this->Html->link('Dashboard', array('admin'=>true, 'controller'=>'admins', 'action'=>'dashboard')) ."&nbsp;&nbsp;/&nbsp;&nbsp;";
		echo $this->Html->link("Sale Tax Lists", array('admin'=>true, 'controller'=>'sale_taxes', 'action'=>'index')) ."&nbsp;&nbsp;/&nbsp;&nbsp;"; 
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
	<div class="col-lg-12">
		<section class="panel"> 
			<header class="panel-heading"><?php 
				echo ($data['SaleTax']['state'] .' - '. $data['SaleTax']['state_code']);?>
			</header>
				
			<table class="dataTable table table-striped table-advance table-hover">
				<tbody> 
					
					<tr>
						<td style="width:24%;">State</td>
						<td><?php echo ($data['SaleTax']['state'])?></td>
					</tr>
						
					<tr>
						<td style="width:20%;">State Code</td>
						<td><?php echo ($data['SaleTax']['state_code'])?$data['SaleTax']['state_code']:'------'; ?></td>
					</tr>
					
					<tr>
						<td>Zip Code</td>
						<td><?php echo ($data['SaleTax']['zip_code']);?></td>
					</tr>
					
				    <tr>
						<td>Tax Region Code</td>
						<td><?php echo ($data['SaleTax']['tax_region_code']?$data['SaleTax']['tax_region_code']:'----');?></td>
					</tr>
					
				    <tr>
						<td>Combined Rate</td>
						<td><?php echo ($data['SaleTax']['combined_rate']?$data['SaleTax']['combined_rate']:'----');?></td>
					</tr>
					
					<tr>
						<td>State Rate</td>
						<td><?php echo ($data['SaleTax']['state_rate']?$data['SaleTax']['state_rate']:'----');?></td>
					</tr>
					
					<tr>
						<td>County Rate</td>
						<td><?php echo ($data['SaleTax']['county_rate']?$data['SaleTax']['county_rate']:'----');?></td>
					</tr>
					
					<tr>
						<td>City Rate</td>
						<td><?php echo ($data['SaleTax']['city_rate']?$data['SaleTax']['city_rate']:'-----');?></td>
					</tr>
					
					<tr>
						<td>Special Rate</td>
						<td><?php echo ($data['SaleTax']['special_rate']?$data['SaleTax']['special_rate']:'-----');?></td>
					</tr>
					
		            <tr>
						<td>Status</td>
						<td><?php echo (Configure::read('Status.'. $data['SaleTax']['status']));?></td>
					</tr>
					
					<tr>
						<td>Registered on</td>
						<td><?php echo date('F d, Y H:i', strtotime($data['SaleTax']['created']));?></td>
					</tr>
					
					<tr>
						<td>Last Updated on</td>
						<td><?php echo date('F d, Y H:i', strtotime($data['SaleTax']['modified']));?></td>
					</tr>
					
					<tr>
						<td colspan="2"><?php
							echo $this->Html->link("<i class='fa fa-caret-square-o-left'></i> Back", array('admin'=>true, 'controller'=>'users', 'action'=>'index'), array("class"=>"btn btn-primary", "escape"=>false)); ?>
						</td>
					</tr>
				</tbody>
			</table>
		</section>
	</div>
	<!-- END PAGE CONTAINER-->
</div>