<?php
$role_id 	= (isset($this->params['pass'][0]))?$this->params['pass'][0]:2; ?>

<ol class="breadcrumb">
	<li><?php echo $this->Html->link('Dashboard', array('admin'=>true, 'controller'=>'admins', 'action'=>'dashboard')); ?></li>
	<li><?php echo $this->Html->link($lable ." Lists", array('admin'=>true, 'controller'=>'users', 'action'=>'index', $role_id)); ?></li>
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
			
				<section class="panel">
					<header class="panel-heading tab-bg padding0">
						<ul class="nav nav-tabs nav-justified ">
							<li class="active">
								<a data-toggle="tab" href="#tab1">General Info</a>
							</li>
							
							<li class="">
								<a data-toggle="tab" href="#tab2">Social Information</a>
							</li>
							
							<li class="">
								<a data-toggle="tab" href="#tab3">Notes</a>
							</li><?php
								
							if($role_id == 2){ ?>
								<li class="">
									<a data-toggle="tab" href="#tab4">Shipping Address</a>
								</li>
								
								<li class="">
									<a data-toggle="tab" href="#tab5">Billing Address</a>
								</li><?php
							} ?>
						</ul>
					</header>

					<div class="panel-body padding0">
						<div class="tab-content tasi-tab">
							<div id="tab1" class="tab-pane padding0 active">
								<table class="table table-hover">
									<tbody>								
										<tr>
											<td style="width:24%; border:0;">Salutation</td>
											<td style="border:0;"><?php echo Configure::read('Salutation.'. $user['User']['salutation'])?></td>
										</tr>
										
										<tr>
											<td style="width:24%;">First Name</td>
											<td><?php echo ($user['User']['first_name'])?></td>
										</tr>
											
										<tr>
											<td style="width:20%;">Last Name</td>
											<td><?php echo ($user['User']['last_name'])?$user['User']['last_name']:'------'; ?></td>
										</tr>
										
										<tr>
											<td>Email</td>
											<td><?php echo ($user['User']['username']);?></td>
										</tr>
											
										<tr>
											<td style="width:20%;">Company Name</td>
											<td><?php echo ($user['User']['company_name'])?$user['User']['company_name']:'------'; ?></td>
										</tr>
											
										<tr>
											<td style="width:20%;">Mobile</td>
											<td><?php echo ($user['User']['mobile'])?$user['User']['mobile']:'------'; ?></td>
										</tr>
											
										<tr>
											<td style="width:20%;">Phone</td>
											<td><?php echo ($user['User']['phone'])?$user['User']['phone']:'------'; ?></td>
										</tr> 
										<tr>
											<td style="width:20%;">Skype</td>
											<td><?php echo ($user['User']['skype'])?$user['User']['skype']:'------'; ?></td>
										</tr>
											
										<tr>
											<td style="width:20%;">Website</td>
											<td><?php echo ($user['User']['website'])?$user['User']['website']:'------'; ?></td>
										</tr> 
										
										<tr>
											<td>Status</td>
											<td><?php echo (Configure::read('Status.'. $user['User']['status']));?></td>
										</tr>
										
										<tr>
											<td>Registered on</td>
											<td><?php echo date('F d, Y H:i', strtotime($user['User']['created']));?></td>
										</tr>
										
										<tr>
											<td>Last Updated on</td>
											<td><?php echo date('F d, Y H:i', strtotime($user['User']['modified']));?></td>
										</tr>
										
										<tr>
											<td colspan="2"><?php
												echo $this->Html->link("<i class='fa fa-caret-square-o-left'></i> Back", array('admin'=>true, 'controller'=>'users', 'action'=>'index', $role_id), array("class"=>"btn btn-default", "escape"=>false)); ?>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						  
							<div id="tab2" class="tab-pane padding0">
								
								<table class="table table-hover">
									<tbody>
										<tr>
											<td style="width:20%; border:0;">Facebook</td>
											<td style="border:0;"><?php echo ($user['User']['facebook'])?$user['User']['facebook']:'------'; ?></td>
										</tr>
											
										<tr>
											<td style="width:20%;">Twitter</td>
											<td><?php echo ($user['User']['twitter'])?$user['User']['twitter']:'------'; ?></td>
										</tr> 
											
										<tr>
											<td style="width:20%;">Google Plus</td>
											<td><?php echo ($user['User']['gplus'])?$user['User']['gplus']:'------'; ?></td>
										</tr> 
											
										<tr>
											<td style="width:20%;">Instagram</td>
											<td><?php echo ($user['User']['instagram'])?$user['User']['instagram']:'------'; ?></td>
										</tr> 
											
										<tr>
											<td style="width:20%;">You Tube</td>
											<td><?php echo ($user['User']['youtube'])?$user['User']['youtube']:'------'; ?></td>
										</tr> 
										
										<tr>
											<td colspan="2"><?php
												echo $this->Html->link("<i class='fa fa-caret-square-o-left'></i> Back", array('admin'=>true, 'controller'=>'users', 'action'=>'index', $role_id), array("class"=>"btn btn-default", "escape"=>false)); ?>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						  
							<div id="tab3" class="tab-pane">
								<p><?php echo ($user['User']['notes'])?$user['User']['notes']:'------'; ?></p>
							</div><?php
							
							if($role_id == 2){ ?>
								<div id="tab4" class="tab-pane padding0">						
									<table class="table table-hover">
										<tbody>
											<tr>
												<td style="width:20%; border:0;">Street</td>
												<td style="border:0;"><?php echo ($user['UserShippingAddress']['street'])?$user['UserShippingAddress']['street']:'------'; ?></td>
											</tr>
												
											<tr>
												<td style="width:20%;">City</td>
												<td><?php echo ($user['UserShippingAddress']['city'])?$user['UserShippingAddress']['city']:'------'; ?></td>
											</tr> 
												
											<tr>
												<td style="width:20%;">State</td>
												<td><?php echo ($user['UserShippingAddress']['state'])?$user['UserShippingAddress']['state']:'------'; ?></td>
											</tr> 
												
											<tr>
												<td style="width:20%;">Zip Code</td>
												<td><?php echo ($user['UserShippingAddress']['zip_code'])?$user['UserShippingAddress']['zip_code']:'------'; ?></td>
											</tr>  
												
											<tr>
												<td style="width:20%;">Country</td>
												<td><?php echo ($user['UserShippingAddress']['country'])?$user['UserShippingAddress']['country']:'------'; ?></td>
											</tr>  
												
											<tr>
												<td style="width:20%;">Fax</td>
												<td><?php echo ($user['UserShippingAddress']['fax'])?$user['UserShippingAddress']['fax']:'------'; ?></td>
											</tr>  
												
											<tr>
												<td style="width:20%;">Phone</td>
												<td><?php echo ($user['UserShippingAddress']['phone'])?$user['UserShippingAddress']['phone']:'------'; ?></td>
											</tr> 
											
											<tr>
												<td colspan="2"><?php
													echo $this->Html->link("<i class='fa fa-caret-square-o-left'></i> Back", array('admin'=>true, 'controller'=>'users', 'action'=>'index', $role_id), array("class"=>"btn btn-default", "escape"=>false)); ?>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								
								<div id="tab5" class="tab-pane padding0">						
									<table class="table table-hover">
										<tbody>
											<tr>
												<td style="width:20%; border:0;">Street</td>
												<td style="border:0;"><?php echo ($user['UserBillingAddress']['street'])?$user['UserBillingAddress']['street']:'------'; ?></td>
											</tr>
												
											<tr>
												<td style="width:20%;">City</td>
												<td><?php echo ($user['UserBillingAddress']['city'])?$user['UserBillingAddress']['city']:'------'; ?></td>
											</tr> 
												
											<tr>
												<td style="width:20%;">State</td>
												<td><?php echo ($user['UserBillingAddress']['state'])?$user['UserBillingAddress']['state']:'------'; ?></td>
											</tr> 
												
											<tr>
												<td style="width:20%;">Zip Code</td>
												<td><?php echo ($user['UserBillingAddress']['zip_code'])?$user['UserBillingAddress']['zip_code']:'------'; ?></td>
											</tr>  
												
											<tr>
												<td style="width:20%;">Country</td>
												<td><?php echo ($user['UserBillingAddress']['country'])?$user['UserBillingAddress']['country']:'------'; ?></td>
											</tr>  
												
											<tr>
												<td style="width:20%;">Fax</td>
												<td><?php echo ($user['UserBillingAddress']['fax'])?$user['UserBillingAddress']['fax']:'------'; ?></td>
											</tr>  
												
											<tr>
												<td style="width:20%;">Phone</td>
												<td><?php echo ($user['UserBillingAddress']['phone'])?$user['UserBillingAddress']['phone']:'------'; ?></td>
											</tr> 
											
											<tr>
												<td colspan="2"><?php
													echo $this->Html->link("<i class='fa fa-caret-square-o-left'></i> Back", array('admin'=>true, 'controller'=>'users', 'action'=>'index', $role_id), array("class"=>"btn btn-default", "escape"=>false)); ?>
												</td>
											</tr>
										</tbody>
									</table>
								</div><?php
							} ?>
							
						</div>
					</div> 
				</section>
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
	</div>
</div>