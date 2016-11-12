<div class="row margin_btm15">
	<div class="col-lg-12"><?php
		echo $this->Html->link('Dashboard', array('admin'=>true, 'controller'=>'admins', 'action'=>'dashboard')) ."&nbsp;&nbsp;/&nbsp;&nbsp;";
		echo $this->Html->link($title_for_layout, "javascript:void(0);"); ?>
	</div> 
</div>

<div class="row margin_btm10">
	<div class="col-lg-12">
		<h3 class="page-title margin_top0"><?php echo $title_for_layout; ?></h3>
	</div>
</div>

<?php echo $this->element('Admin/cart_header'); ?>

<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">Search</header>
			
			<div class="panel-body"><?php
				$status = (isset($this->params['pass'][0]))?$this->params['pass'][0]:'';
				
				echo $this->Form->create('Product', array(
					'url'=>array('controller'=>'product_solds', 'action'=>'select_product'), 
					'class'=>'form-inline',
					'role'=>'form'
				)); 
				
					$keywords  = $this->Session->read('AdminSearch'); ?>
				
					<div class="form-group">
						<label class="sr-only" for="UserFirstName">Search Keyword</label><?php
						echo $this->Form->input('keyword', array('type'=>'text', 'placeholder'=>'Search Keyword', 'div'=>false, "class"=>"form-control", 'value'=>$keywords, 'label'=>false)); ?>
					</div>&nbsp;<?php
				
					echo $this->Form->submit("Search", array("class"=>"btn btn-success", 'div'=>false)); echo "&nbsp;";
					echo $this->Html->link('Show All', array('controller'=>'product_solds', 'action'=>'select_product'), array('escape'=>false, 'class'=>'btn btn-success'));
					
				echo $this->Form->end(); ?>
			</div>
		</section>
	</div>
</div>

<?php echo $this->element('Admin/paging_counter'); ?>

<div class="row">
	<div class="col-lg-12">
		<section class="panel"><?php
				
			if($data){ 
				$asc_desc = isset($this->params['named']['direction'])?$this->params['named']['direction']:'';
				$sort_by  = isset($this->params['named']['sort'])?$this->params['named']['sort']:'';
				$sort_by  = ($sort_by)?explode('.', $sort_by):'';
				$sort_by  = isset($sort_by[1])?$sort_by[1]:''; ?>
			
				<table class="dataTable table table-striped table-advance table-hover">
					<thead>
						<tr>
							<th class="sorting<?php echo ($sort_by=='title')?'_'.$asc_desc:''; ?> "><span class="m7"><?php echo $this->ExPaginator->sort('Product.title', 'Title'); ?> </span></th>
							<th class="hidden-phone sorting<?php echo ($sort_by=='first_name')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('User.first_name', 'Vendor'); ?> </span></th>
							<th class="hidden-phone sorting<?php echo ($sort_by=='name')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('Category.name', 'Category'); ?> </span></th>
							<th class="sorting<?php echo ($sort_by=='name')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('SubCategory.name', 'Sub Category'); ?> </span></th>
							<th class="sorting<?php echo ($sort_by=='selling_price')?'_'.$asc_desc:''; ?>"><span class="m7"><?php echo $this->ExPaginator->sort('Product.selling_price', 'Selling Price'); ?> </span></th>
							<th class="center">Quantity</th>
							<th class="actionW"></th>
						</tr>
					</thead>
					
					<tbody><?php 
						$my_cart 		= $this->Session->read('MyCart');
						foreach($data as $value){
							$selected_qty	= (isset($my_cart['Products'][$value['Product']['id']]['quantity']) and $my_cart['Products'][$value['Product']['id']]['quantity'])?$my_cart['Products'][$value['Product']['id']]['quantity']:''; 
							$default_val	= ($selected_qty)?$selected_qty:1; 
							$selected_qty	= ($selected_qty)?'('. $selected_qty .')':''; ?>
							<tr>
								<td><?php echo $this->Html->link($value['Product']['title'], array('controller'=>'products', 'action'=>'view', $value['Product']['id']), array('target'=>'_blank')); ?></td>
								<td class="hidden-phone"><?php echo $value['User']['first_name'] .' '. $value['User']['last_name']; ?></td>
								<td class="hidden-phone"><?php echo $value['Category']['name']; ?></td>
								<td class="hidden-phone"><?php echo $value['SubCategory']['name']; ?></td>
								<td class="hidden-phone">$<?php echo $value['Product']['selling_price']; ?></td>
								<td class="center", style="width:150px;"><?php
									$max_val = (int)$value['Product']['total_purchased_product'] - (int)$value['Product']['total_sold_out_product'];
									echo $this->Form->input("qty", array('id'=>'qty_'. $value['Product']['id'], 'name'=>'data[Product][keyword]['. $value['Product']['id'] .']', 'type'=>'number', 'min'=>1, 'max'=>$max_val, 'div'=>false, 'label'=>false, 'default'=>$default_val, 'class'=>'form-control')); ?>
									<span class="danger error_qty" id="error_<?php echo $value['Product']['id']; ?>"></span>
								</td>
								<td class="center"><?php 
									echo $this->Html->link('<i class="fa fa-shopping-cart"></i> Add <span id="cart_btn_'. $value['Product']['id'] .'">'. $selected_qty .'</span>', 'javascript:void(0);', array('onClick'=>'addToCart('. $value['Product']['id'] .', '. $max_val .')', 'class'=>'btn btn-default', 'escape'=>false)); ?>
								</td>
							</tr><?php
						} ?>
					</tbody>
				</table><?php
				
				$this->Paginator->options(array('url' => $this->passedArgs));
				echo $this->element('Admin/admin_pagination', array("paging_model_name"=>"Product", "total_title"=>"Product Lists"));
			}else{
				echo "<div class='no-record-found'>No Information for Display.</div>";
			} ?>
		</section>
	</div>
</div>

<script type="text/javascript">
	function addToCart(product_id, max_qty){
		jQuery('.error_qty').html('');
		
		var quantity= jQuery("#qty_"+ product_id).val();
		quantity 	= parseInt(quantity, 10);
		max_qty 	= parseInt(max_qty, 10);
		
		if(quantity > 0){
			if(quantity > max_qty){
				jQuery('#error_'+ product_id).html('Maximum quantity limit is '+ max_qty +'.');
				return false;
			}else{
				jQuery.ajax({
					type: "POST",
					url: "<?php echo Router::url(array('admin'=>true, 'controller'=>'product_solds', 'action'=>'add_in_cart'), true); ?>",
					data: "product_id="+ product_id +"&quantity="+ quantity,  
					dataType: "html",
					success: function(data) { 
						jQuery('#cart_btn_'+ product_id).html( "("+ quantity +")");
					}
				}); 
			}
		}else{
			jQuery('#error_'+ product_id).html('Please enter a valid quantity.');
			return false;
		}
	}
</script>