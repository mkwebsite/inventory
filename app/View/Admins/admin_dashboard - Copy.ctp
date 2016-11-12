<div class="pageheader">
	<h2><?php echo $title_for_layout; ?></h2>
</div>

<div class="row">
	<div class="orderwrap col-md-12">
		<div class="col-md-3 col-sm-6 col-xs-12 orderbox"> 
			<div class="ordernewbox">
				<div class="roundbox green pull-left"><span class="fa fa-check-square-o"></span></div>
				<div class="neworder1">
					0<span class="ordertext">Quantity</span>
				</div>
			</div>

			<div></div>
			<div class="progress-list">
				<div class="details">
					<div class="description"><i class="fa fa-check-square-o"></i> Quantity to be Packed</div>
				</div>

				<div class="clearfix"></div> 
			</div>
		</div>
		
		<div class="col-md-3 col-sm-6 col-xs-12 orderbox"> 
			<div class="ordernewbox">
				<div class="roundbox yallow pull-left"><span class="fa fa-truck"></span></div>
				<div class="neworder1">
					0<span class="ordertext">Packages</span>
				</div>
			</div>

			<div></div>
			<div class="progress-list">
				<div class="details">
					<div class="description"><i class="fa fa-truck"></i> Packages to be Shipped</div>
				</div>

				<div class="clearfix"></div> 
			</div>
		</div>
		
		<div class="col-md-3 col-sm-6 col-xs-12 orderbox"> 
			<div class="ordernewbox">
				<div class="roundbox green pull-left"><span class="fa fa-ticket"></span></div>
				<div class="neworder1">
					0<span class="ordertext">Packages</span>
				</div>
			</div>

			<div></div>
			<div class="progress-list">
				<div class="details">
					<div class="description"><i class="fa fa-ticket"></i> Packages to be Delivered</div>
				</div>

				<div class="clearfix"></div> 
			</div>
		</div>
		
		<div class="col-md-3 col-sm-6 col-xs-12 orderbox"> 
			<div class="ordernewbox">
				<div class="roundbox yallow pull-left"><span class="fa fa-file-text-o"></span></div>
				<div class="neworder1">
					0<span class="ordertext">Quantity</span>
				</div>
			</div>

			<div></div>
			<div class="progress-list">
				<div class="details">
					<div class="description"><i class="fa fa-file-text-o"></i> Quantity to be Invoiced</div>
				</div>

				<div class="clearfix"></div> 
			</div>
		</div>
	</div>
</div>


<?php

/*
<div class="row state-overview">
	<div class="col-lg-3 col-sm-6">
		<a href="<?php echo Router::url(array('admin'=>true, 'controller'=>'users', 'action'=>'index', 2), true); ?>" title="Visit Customers">
			<section class="panel">
				<div class="symbol terques">
					<i class="fa fa-user"></i>
				</div>
				<div class="value">
					<h1 class="count"><?php echo $customers; ?></h1>
					<p>Customers</p>
				</div>
			</section>
		</a>
	</div>
	
	<div class="col-lg-3 col-sm-6">
		<a href="<?php echo Router::url(array('admin'=>true, 'controller'=>'users', 'action'=>'index', 3), true); ?>" title="Visit Vendors">
			<section class="panel">
				<div class="symbol red">
					<i class="fa fa-shopping-cart"></i>
				</div>
				<div class="value">
					<h1 class=" count2"><?php echo $vendors; ?></h1>
					<p>Vendors</p>
				</div>
			</section>
		</a>
	</div>
	
	<div class="col-lg-3 col-sm-6">
		<a href="<?php echo Router::url(array('admin'=>true, 'controller'=>'products', 'action'=>'index', 1), true); ?>" title="Visit Active Products">
			<section class="panel">
				<div class="symbol yellow">
					<i class="fa fa-gears"></i>
				</div>
				<div class="value">
					<h1 class=" count2"><?php echo $active_products; ?></h1>
					<p>Active Products</p>
				</div>
			</section>
		</a>
	</div>
	
	<div class="col-lg-3 col-sm-6">
		<a href="<?php echo Router::url(array('admin'=>true, 'controller'=>'products', 'action'=>'index', 2), true); ?>" title="Visit Inactive Products">
			<section class="panel">
				<div class="symbol blue">
					<i class="fa fa-gears"></i>
				</div>
				<div class="value">
					<h1 class=" count2"><?php echo $inactive_products; ?></h1>
					<p>Inactive Products</p>
				</div>
			</section>
		</a>
	</div>
</div>


<div class="row state-overview">	
	<div class="col-lg-3 col-sm-6">
		<a href="<?php echo Router::url(array('admin'=>true, 'controller'=>'settings', 'action'=>'index'), true); ?>" title="Visit Settings">
			<section class="panel">
				<div class="symbol terques">
					<i class="fa fa-cog"></i>
				</div>
				<div class="value">
					<h1 class=" count2">&nbsp;</h1>
					<p>Settings</p>
				</div>
			</section>
		</a>
	</div>
	
	<div class="col-lg-3 col-sm-6">
		<a href="<?php echo Router::url(array('admin'=>true, 'controller'=>'countries', 'action'=>'index'), true); ?>" title="Visit Countries">
			<section class="panel">
				<div class="symbol red">
					<i class="fa fa-map-marker"></i>
				</div>
				<div class="value">
					<h1 class=" count2"><?php echo $countries; ?></h1>
					<p>Countries</p>
				</div>
			</section>
		</a>
	</div>
	
	<div class="col-lg-3 col-sm-6">
		<a href="<?php echo Router::url(array('admin'=>true, 'controller'=>'categories', 'action'=>'index'), true); ?>" title="Visit Categories">
			<section class="panel">
				<div class="symbol yellow">
					<i class="fa fa-sitemap"></i>
				</div>
				<div class="value">
					<h1 class=" count2"><?php echo $categories; ?></h1>
					<p>Categories</p>
				</div>
			</section>
		</a>
	</div>
	
	<div class="col-lg-3 col-sm-6">
		<a href="<?php echo Router::url(array('admin'=>true, 'controller'=>'sale_taxes', 'action'=>'index'), true); ?>" title="Visit Sale Taxes">
			<section class="panel">
				<div class="symbol blue">
					<i class="fa fa-laptop"></i>
				</div>
				<div class="value">
					<h1 class=" count2"><?php echo $sale_taxes; ?></h1>
					<p>Sale Taxes</p>
				</div>
			</section>
		</a>
	</div>
</div> */ ?>