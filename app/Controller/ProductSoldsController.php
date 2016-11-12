<?php
	/**
		* ProductSolds Controller
		*
		* PHP version 5.4
		*
	*/
	class ProductSoldsController  extends AppController {
		/**
			* Controller name
			*
			* @var string
			* @access public
		*/
		var	$name	= 'ProductSolds'; 
		var	$uses	= array('ProductSold', 'Product', 'User', 'ProductSalesorder');
		
		/*
			* beforeFilter
			* @return void
		*/
		public function beforeFilter() {
			parent::beforeFilter();
		}
		
		
		
		/*
		** get customers lists
		*/
		public function admin_get_cust_list(){
			
			$key = isset($this->params->query['term'])?$this->params->query['term']:''; 
			if($key == '')die;
			
			$city_data = $this->User->find('all', array(
				'limit'		=> Configure::read('AutosujetionLimit'),
				'fields'	=> array('User.id', 'User.first_name', 'User.last_name', 'User.city', 'User.state'), 
				'conditions'=> array('User.status'=>1, 'User.role_id'=>2, 'OR'=>array('User.first_name Like '=>$key.'%', 'User.last_name Like '=>$key.'%', 'User.username Like '=>$key.'%', 'User.city Like '=>$key.'%', 'User.state Like '=>$key.'%', 'User.zip_code Like '=>$key.'%', 'User.mobile Like '=>$key.'%', 'User.phone Like '=>$key.'%'))
			));
			
			$data = array();
			
			foreach($city_data as $val){
				$data[] = array(
					'label' 	=> $val['User']['first_name'] .' '. $val['User']['last_name'] .' ('. $val['User']['city'] .', '. $val['User']['state'] .')',
					'value' 	=> $val['User']['first_name'],
					'last_name' => $val['User']['last_name'],
					'user_id'   => $val['User']['id'],
				);
			}
				
			echo json_encode($data);
			flush();
			die;
		}
		
		
		
		/*
		** Generate new order
		*/
		public function admin_add_in_cart(){
			$product_id = (isset($this->request->data['product_id']))?$this->request->data['product_id']:'';
			$quantity	= (isset($this->request->data['quantity']))?$this->request->data['quantity']:'';
			
			$products 		= array();
			$total_quantity			= ($this->Session->read('MyCart.total.quantity'))?$this->Session->read('MyCart.total.quantity'):0;
			$total_selling_price	= ($this->Session->read('MyCart.total.selling_price'))?$this->Session->read('MyCart.total.selling_price'):0;
			$total_total_cost		= ($this->Session->read('MyCart.total.total_cost'))?$this->Session->read('MyCart.total.total_cost'):0;
			$total_producer_cost	= ($this->Session->read('MyCart.total.producer_cost'))?$this->Session->read('MyCart.total.producer_cost'):0;
			$total_other_charges	= ($this->Session->read('MyCart.total.other_charges'))?$this->Session->read('MyCart.total.other_charges'):0;
			$product_ids			= ($this->Session->read('MyCart.product_ids'))?$this->Session->read('MyCart.product_ids'):'';
			if($quantity and $product_id){
				$products['Products'] 	= $this->Session->read('MyCart.Products');
				$already_selected_qty 	= (isset($products['Products'][$product_id]['quantity']) and $products['Products'][$product_id]['quantity'])?$products['Products'][$product_id]['quantity']:0; 
				$already_selling_price	= (isset($products['Products'][$product_id]['selling_price']) and $products['Products'][$product_id]['selling_price'])?$products['Products'][$product_id]['']:0;
				$already_total_cost		= (isset($products['Products'][$product_id]['total_cost']) and $products['Products'][$product_id]['total_cost'])?$products['Products'][$product_id]['total_cost']:0;
				$already_producer_cost	= (isset($products['Products'][$product_id]['producer_cost']) and $products['Products'][$product_id]['producer_cost'])?$products['Products'][$product_id]['producer_cost']:0;
				$already_other_charges	= (isset($products['Products'][$product_id]['other_charges']) and $products['Products'][$product_id]['other_charges'])?$products['Products'][$product_id]['other_charges']:0; 
				
				$data = $this->Product->find('first', array('conditions'=>array('Product.status'=>1, 'Product.id'=>$product_id)));
				if($data){
					$product_ids[$product_id] = $product_id;
					$products['Products'][$product_id]['product_id'] 	= $product_id;
					$products['Products'][$product_id]['quantity'] 	 	= $quantity;
					$products['Products'][$product_id]['selling_price'] = (float)$data['Product']['selling_price'] * (int)$quantity;
					$products['Products'][$product_id]['total_cost'] 	= (float)$data['Product']['total_cost'] * (int)$quantity;
					$products['Products'][$product_id]['producer_cost'] = (float)$data['Product']['producer_cost'] * (int)$quantity;
					$products['Products'][$product_id]['other_charges'] = (float)$data['Product']['other_charges'] * (int)$quantity;
					$this->Session->write('MyCart.Products', $products['Products']);
					
					$total_quantity			= (int)$total_quantity + (int)$quantity - (int)$already_selected_qty;
					$total_selling_price	= (int)$total_selling_price + ((int)$quantity * (float)$data['Product']['selling_price']) - (int)$already_selling_price;
					$total_total_cost		= (int)$total_total_cost + ((int)$quantity * (float)$data['Product']['total_cost']) - (int)$already_total_cost;
					$total_producer_cost	= (int)$total_producer_cost + ((int)$quantity * (float)$data['Product']['producer_cost']) - (int)$already_producer_cost;
					$total_other_charges	= (int)$total_other_charges + ((int)$quantity * (float)$data['Product']['other_charges']) - (int)$already_other_charges;
				}
				
				$this->Session->write('MyCart.total.quantity', $total_quantity);
				$this->Session->write('MyCart.total.selling_price', $total_selling_price);
				$this->Session->write('MyCart.total.total_cost', $total_total_cost);
				$this->Session->write('MyCart.total.producer_cost', $total_producer_cost);
				$this->Session->write('MyCart.total.other_charges', $total_other_charges);
				$this->Session->write('MyCart.product_ids', $product_ids);
			}
			
			die;
		}
		
		
		
		/*
		** cart
		*/
		public function admin_cart(){
			pr($this->Session->read('MyCart')); die;
			$this->set('title_for_layout',  __('Customer Order Lists', true)) ;
		
		}
		
		
		
		
		/*
		** Generate new order
		*/
		public function admin_clear_cart(){
			$this->Session->delete('MyCart');
			$this->Session->setFlash('Cart item has been cleared successfuly.', 'admin_flash_success');
			$this->redirect(array('admin'=>true, 'controller'=>'product_solds', 'action'=>'generate_new')) ;
		}
		
		
		/*
		** Generate new order
		*/
		public function admin_generate_new() { //pr($this->Session->read('MyCart')); die;
			$this->set('title_for_layout',  __('Generate New Order', true)) ;
		
			if ($this->request->is('post') || $this->request->is('put')){
				//check empty
				if(!empty($this->request->data)) {
					if (!isset($this->request->params['data']['_Token']['key']) || ($this->request->params['data']['_Token']['key'] != $this->request->params['_Token']['key'])) {
						$blackHoleCallback = $this->Security->blackHoleCallback;
						$this->$blackHoleCallback();
					}
					//validate Product data
					$this->ProductSold->set($this->request->data);
					$this->ProductSold->setValidation('admin');
					if($this->ProductSold->validates()){
						$this->Session->write('MyCart.Cust_Info', $this->request->data['ProductSold']);
						$this->redirect(array('admin'=>true, 'controller'=>'product_solds', 'action'=>'select_product')) ;
					}else{
						$this->Session->setFlash('Product could not be saved. Please correct errors.', 'admin_flash_error');
					}
				}
			}else{
				$this->request->data['ProductSold'] = $this->Session->read('MyCart.Cust_Info');
			}
		}
		
		
		
		
		
		public function admin_select_product(){
			$this->set('title_for_layout',  __('Select Products', true)) ;
			$filters = array('Product.status'=>array(1));
			if(!isset($this->request->params['named']['page']) and !isset($this->request->params['named']['sort'])){
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
			}	
			
			if(!empty($this->request->data)){			
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
				
				App::uses('Sanitize', 'Utility');		
				if(!empty($this->data['Product']['keyword'])){				
					$name = Sanitize::escape($this->request->data['Product']['keyword']);
					$this->Session->write('AdminSearch.keyword', $name);				
				}
			}
			
			if($this->Session->check('AdminSearch')){
				$keyword  = $this->Session->read('AdminSearch.keyword');			
				$filters[] = array('OR'=>array('Product.product_sku LIKE'=>$keyword."%", 'Product.title LIKE'=>$keyword."%", 'Product.description LIKE'=>$keyword."%", 'User.first_name LIKE'=>$keyword."%", 'User.last_name LIKE'=>$keyword."%", 'Category.name LIKE'=>$keyword."%", 'SubCategory.name LIKE'=>$keyword."%"));
			}
			
			$this->Product->bindModel(array('belongsTo'=>array(
				'Category', 'User', 'SubCategory'=>array('className'=>'Category', 'foreignKey'=>'sub_category_id')
			)), false);
			
			$this->paginate = array(
				'Product'	=> array(
					'fields'			=> array('Product.*', 'User.first_name', 'User.last_name', 'Category.name', 'SubCategory.name'),
					'limit'				=> Configure::read('App.AdminPageLimit'), 
					'order'				=> array('Product.modified'=>'DESC'),
					'conditions'		=> $filters
			));
			
			$data = $this->paginate('Product');
			$this->set(compact('data'));		
		}
		
		
		
		
		/*
		** List all products in admin panel
		*/
		public function admin_index($defaultTab=null) {
			$this->set('title_for_layout',  __('Sales Order Listing', true)) ;
			if(!isset($this->request->params['named']['page']) and !isset($this->request->params['named']['sort'])){
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
			}	
			
			$filters = array('ProductSold.status'=>array(1,2,3,4));
			if($defaultTab){
				$filters 		  = array('ProductSold.status'=>$defaultTab);
				$title_for_layout = "Sales Order Listing (". Configure::read('SalesStatus.'. $defaultTab) .")";
				$this->Session->write('Url.defaultTab', $defaultTab);
			}
			
			if(!empty($this->request->data)){			
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
				
				App::uses('Sanitize', 'Utility');		
				if(!empty($this->data['ProductSold']['keyword'])){				
					$name = Sanitize::escape($this->request->data['ProductSold']['keyword']);
					$this->Session->write('AdminSearch.keyword', $name);				
				}
			}
			
			if($this->Session->check('AdminSearch')){
				$keyword  = $this->Session->read('AdminSearch.keyword');			
				$filters[] = array('OR'=>array('ProductSold.order_sku LIKE'=>$keyword."%", 'User.first_name LIKE'=>$keyword."%", 'User.last_name LIKE'=>$keyword."%"));
			}
			
			
			$this->ProductSold->bindModel(array('belongsTo'=>array('User')), false);
			$this->paginate = array(
				'ProductSold'	=> array(
					'fields'			=> array('ProductSold.*', 'User.first_name', 'User.last_name'),
					'limit'				=> Configure::read('App.AdminPageLimit'), 
					'order'				=> array('Product.modified'=>'DESC'),
					'conditions'		=> $filters
				));
			
			$data 		= $this->paginate('ProductSold');   
     		$new     	= $this->ProductSold->find('count',array('conditions'=>array('ProductSold.status'=>1)));
			$packed 	= $this->ProductSold->find('count',array('conditions'=>array('ProductSold.status'=>2)));
			$dispached 	= $this->ProductSold->find('count',array('conditions'=>array('ProductSold.status'=>3)));
			$delivered 	= $this->ProductSold->find('count',array('conditions'=>array('ProductSold.status'=>4)));
			$all		= (int)$new + (int)$packed + (int)$dispached + (int)$delivered;
			//pr($data);die; 
			$this->set(compact('data','new','packed','dispached','delivered','all'));		
			
		}
		
		
		
		public function admin_view($id = null) {
			$this->set('title_for_layout',  __('Sales Order Information', true)) ;
			$result = array();
			
			$this->ProductSold->id = $id;
			if (!$this->ProductSold->exists()) {
				throw new NotFoundException(__('Invalid Sales Order Information'));
			}
			
			if ($this->request->is('post') || $this->request->is('put')) {					
				if(!empty($this->request->data)) {
					
					if($this->request->data['ProductSold']['status'] == 2){
						$this->request->data['ProductSold']['packed_date'] = date('Y-m-d H:i:s');
					}else if($this->request->data['ProductSold']['status'] == 3){
						$this->request->data['ProductSold']['dispached_date'] = date('Y-m-d H:i:s');
					}else if($this->request->data['ProductSold']['status'] == 4){
						$this->request->data['ProductSold']['delivered_date'] = date('Y-m-d H:i:s');
					}else if($this->request->data['ProductSold']['status'] == 5){
						$this->request->data['ProductSold']['canceled_date'] = date('Y-m-d H:i:s');
					}else if($this->request->data['ProductSold']['status'] == 6){
						$this->request->data['ProductSold']['returned_date'] = date('Y-m-d H:i:s');
					}
					
					
					if($this->ProductSold->saveAll($this->request->data)){
						$this->Session->setFlash(__('Sales status has been updated successfully.',true), 'admin_flash_success');
						$this->redirect(array('action'=>'view', $id)) ;
					}else{
						$this->Session->setFlash(__('Sales status could not be updated. Please try again.', true), 'admin_flash_error');
					}
				}	
			}
			
			$this->ProductSold->bindModel(array('belongsTo'=>array('User')), false);
			$this->set('data', $this->ProductSold->read(null, $id));
			
			$this->ProductSalesorder->bindModel(array('belongsTo'=>array('Product')), false);
     		$orders_product  = $this->ProductSalesorder->find('all',array('conditions'=>array('ProductSalesorder.product_sold_id'=>$id)));
			$this->set('orders_product', $orders_product);
		}
		
		
		
		
		
		/*
		** List all products in admin panel
		*/
		public function admin_returned($defaultTab=null) {
			$this->set('title_for_layout',  __('Canceled and Returned Order Listing', true)) ;
			if(!isset($this->request->params['named']['page']) and !isset($this->request->params['named']['sort'])){
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
			}	
			
			$filters = array('ProductSold.status'=>array(5,6));
			if($defaultTab){
				$filters 		  = array('ProductSold.status'=>$defaultTab);
				$title_for_layout = "Sales Order Listing (". Configure::read('SalesStatus.'. $defaultTab) .")";
				$this->Session->write('Url.defaultTab', $defaultTab);
			}
			
			if(!empty($this->request->data)){			
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
				
				App::uses('Sanitize', 'Utility');		
				if(!empty($this->data['ProductSold']['keyword'])){				
					$name = Sanitize::escape($this->request->data['ProductSold']['keyword']);
					$this->Session->write('AdminSearch.keyword', $name);				
				}
			}
			
			if($this->Session->check('AdminSearch')){
				$keyword  = $this->Session->read('AdminSearch.keyword');			
				$filters[] = array('OR'=>array('ProductSold.order_sku LIKE'=>$keyword."%", 'User.first_name LIKE'=>$keyword."%", 'User.last_name LIKE'=>$keyword."%"));
			}
			
			
			$this->ProductSold->bindModel(array('belongsTo'=>array('User')), false);
			$this->paginate = array(
				'ProductSold'	=> array(
					'fields'			=> array('ProductSold.*', 'User.first_name', 'User.last_name'),
					'limit'				=> Configure::read('App.AdminPageLimit'), 
					'order'				=> array('Product.modified'=>'DESC'),
					'conditions'		=> $filters
				));
			
			$data 		= $this->paginate('ProductSold');   
			$canceled 	= $this->ProductSold->find('count',array('conditions'=>array('ProductSold.status'=>5)));
			$returned 	= $this->ProductSold->find('count',array('conditions'=>array('ProductSold.status'=>6)));
			$all		= (int)$canceled + (int)$returned;
			
			$this->set(compact('data', 'canceled', 'returned', 'all'));			
		}
		
		
		
		public function admin_returned_view($id = null) {
			$this->set('title_for_layout',  __('Sales Order Information', true)) ;
			$result = array();
			
			$this->ProductSold->id = $id;
			if (!$this->ProductSold->exists()) {
				throw new NotFoundException(__('Invalid Sales Order Information'));
			}
			
			$this->ProductSold->bindModel(array('belongsTo'=>array('User')), false);
			$this->set('data', $this->ProductSold->read(null, $id));
			
			$this->ProductSalesorder->bindModel(array('belongsTo'=>array('Product')), false);
     		$orders_product  = $this->ProductSalesorder->find('all',array('conditions'=>array('ProductSalesorder.product_sold_id'=>$id)));
			$this->set('orders_product', $orders_product);
		}		
	}