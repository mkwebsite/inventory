<?php
	/**
		* Purchases Controller
		*
		* PHP version 5.4
		*
	*/
	class PurchasesController  extends AppController {
		/**
			* Controller name
			*
			* @var string
			* @access public
		*/
		public $components = array('Common');
		var	$name	= 'Purchases'; 
		var	$uses	=	array('Purchase', 'User', 'Category');
		
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
			'fields'	=> array('User.id', 'User.first_name', 'User.last_name', 'User.salutation', 'User.username'), 
			'conditions'=> array('User.status'=>1, 'User.role_id'=>3, 'OR'=>array('User.first_name Like '=>$key.'%', 'User.last_name Like '=>$key.'%', 'User.username Like '=>$key.'%', 'User.mobile Like '=>$key.'%', 'User.phone Like '=>$key.'%'))
			));
			
			$data = array();
			
			foreach($city_data as $val){
				$name = Configure::read('Salutation.'. $val['User']['salutation']) .' '. $val['User']['first_name'] .' '. $val['User']['last_name'] ;
				$email= $name ." (". $val['User']['username'] .")";
				$data[] = array(
				'label' 	=> $name,
				'value' 	=> $name,
				'last_name' => $val['User']['last_name'],
				'user_id'   => $val['User']['id'],
				'email'   	=> $email 
				);
			}
			
			echo json_encode($data);
			flush();
			die;
		}
		
		
		/*
			** get customers lists
		*/
		public function admin_get_cust_user_list(){
			
			$key = isset($this->params->query['term'])?$this->params->query['term']:''; 
			if($key == '')die;
			
			$city_data = $this->User->find('all', array(
			'limit'		=> Configure::read('AutosujetionLimit'),
			'fields'	=> array('User.id', 'User.first_name', 'User.last_name', 'User.salutation', 'User.username'), 
			'conditions'=> array('User.status'=>1, 'User.role_id'=>2, 'OR'=>array('User.first_name Like '=>$key.'%', 'User.last_name Like '=>$key.'%', 'User.username Like '=>$key.'%', 'User.mobile Like '=>$key.'%', 'User.phone Like '=>$key.'%'))
			));
			
			$data = array();
			
			foreach($city_data as $val){
				$name = Configure::read('Salutation.'. $val['User']['salutation']) .' '. $val['User']['first_name'] .' '. $val['User']['last_name'] ;
				$email= $name ." (". $val['User']['username'] .")";
				$data[] = array(
				'label' 	=> $name,
				'value' 	=> $name,
				'last_name' => $val['User']['last_name'],
				'user_id'   => $val['User']['id'],
				'email'   	=> $email 
				);
			}
			
			echo json_encode($data);
			flush();
			die;
		}
		
		
		
		
		
		/*
			** get product lists
		*/
		public function admin_product_info(){
			$this->loadModel('Product');
			$key = isset($this->params->query['term'])?$this->params->query['term']:''; 
			if($key == '')die;
			
			$city_data = $this->Product->find('all', array(
			'limit'		=> Configure::read('AutosujetionLimit'),
			'conditions'=> array('OR'=>array('Product.name Like '=>$key.'%', 'Product.sku Like '=>$key.'%'))
			));
			
			$data = array();
			
			foreach($city_data as $val){
				$name = $val['Product']['sku'] .': '. $val['Product']['name']; // .'\r\r\n'. $val['Product']['sales_desc'];
				$data[] = array(
				'label' 	=> $name,
				'value' 	=> $name,
				'rate' 		=> $val['Product']['sales_account'],
				'product_id'=> $val['Product']['id'],
				'tax'   	=> $val['Product']['sales_tax'],
				'amount'   	=> $val['Product']['sales_account'] + $val['Product']['sales_tax']
				);
			}
			
			
			echo json_encode($data);
			flush();
			die;
		}
		
		
		
		
		
		public function admin_add_row(){
			$row_id = (isset($this->request->data['row_id']))?$this->request->data['row_id']:'';
			if($row_id){
				$row_id++;
				$this->set('i', $row_id);
				$this->render('/Elements/Admin/Purchase/add_product');
				} else{
				die;
			}
		}
		
		
		
		
		
		
		/*
			** List all products in admin panel
		*/
		public function admin_index($defaultTab=null){
			
			$this->set('title_for_layout',  __('Purchase Order Listing', true)) ;
			if(!isset($this->request->params['named']['page']) and !isset($this->request->params['named']['sort'])){
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
			}	
			
			$filters = array();
			if($defaultTab){
				$filters 		  = array('Purchase.status'=>$defaultTab);
				$title_for_layout = "Purchases Order Listing (". Configure::read('PurchasesStatus.'. $defaultTab) .")";
				$this->Session->write('Url.defaultTab', $defaultTab);
			}
			
			if(!empty($this->request->data)){			
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
				
				App::uses('Sanitize', 'Utility');		
				if(!empty($this->data['Purchase']['keyword'])){				
					$name = Sanitize::escape($this->request->data['Purchase']['keyword']);
					$this->Session->write('AdminSearch.keyword', $name);				
				}
			}
			
			if($this->Session->check('AdminSearch')){
				$keyword  = $this->Session->read('AdminSearch.keyword');			
				$filters[] = array('OR'=>array('Purchase.order_no LIKE'=>$keyword."%", 'User.first_name LIKE'=>$keyword."%", 'User.last_name LIKE'=>$keyword."%"));
			} 
			
			$this->Purchase->bindModel(array('belongsTo'=>array('User')), false);
			$this->paginate = array(
			'Purchase'	=> array(
			'fields'			=> array('Purchase.*', 'User.first_name', 'User.last_name'),
			'limit'				=> Configure::read('App.AdminPageLimit'), 
			'order'				=> array('Purchase.modified'=>'DESC'),
			'conditions'		=> $filters
			));
			
			$data 		= $this->paginate('Purchase');   
     		$new     	= $this->Purchase->find('count',array('conditions'=>array('Purchase.status'=>1)));
			$packed 	= $this->Purchase->find('count',array('conditions'=>array('Purchase.status'=>2)));
			$dispached 	= $this->Purchase->find('count',array('conditions'=>array('Purchase.status'=>3)));
			$delivered 	= $this->Purchase->find('count',array('conditions'=>array('Purchase.status'=>4)));
			$canceled 	= $this->Purchase->find('count',array('conditions'=>array('Purchase.status'=>5)));
			$returned 	= $this->Purchase->find('count',array('conditions'=>array('Purchase.status'=>6)));
			$all		= (int)$new + (int)$packed + (int)$dispached + (int)$delivered + (int)$canceled + (int)$returned; 
			$this->set(compact('data','new','packed','dispached','delivered','canceled','returned','all'));		
		}
		
		
		
		public function admin_add() {	
			$this->set('title_for_layout',  __('New Purchase Order', true)) ;
			
			if ($this->request->is('post')) {
				 
				//check empty
				if(!empty($this->request->data)){
					if (!isset($this->request->params['data']['_Token']['key']) || ($this->request->params['data']['_Token']['key'] != $this->request->params['_Token']['key'])) {
						$blackHoleCallback = $this->Security->blackHoleCallback;
						$this->$blackHoleCallback();
					}
					
					//validate Purchase data
					$this->Purchase->set($this->request->data);
					$this->Purchase->setValidation('admin');
					if ($this->Purchase->validates()) {
						
						$items = (isset($this->request->data['Purchase']['p']))?$this->request->data['Purchase']['p']:'';
						unset($this->request->data['Purchase']['p']);
						
						//pr($this->request->data); die; 
						
						$deliver_to = isset($this->request->data['Purchase']['deliver_to'])?$this->request->data['Purchase']['deliver_to']:'';
						if($deliver_to==2) {
							$customer_id = $this->request->data['Purchase']['customer_id'];
						} else {
							$customer_id = $this->Auth->user('id');
						} 
						$this->request->data['Purchase']['deliver_type'] = $deliver_to;
						$this->request->data['Purchase']['deliver_to'] = $customer_id;  
						//pr($this->request->data); die; 
						
						//pr($this->request->data); pr($items); die;
						if ($this->Purchase->saveAll($this->request->data)) {
							$purchase_id = $this->Purchase->id; 
							if($items){
								$this->loadModel('PurchaseProduct');
								foreach($items as $val){
									$sale_products = array();
									$sale_products['PurchaseProduct']['product_id']		= $val['product_id'];
									$sale_products['PurchaseProduct']['purchase_id']		= $purchase_id;
									$sale_products['PurchaseProduct']['qty']			= $val['quantity'];
									$sale_products['PurchaseProduct']['rate']			= $val['rate'];
									$sale_products['PurchaseProduct']['discount']		= $val['discount'];
									$sale_products['PurchaseProduct']['tax']			= $val['tax'];
									$sale_products['PurchaseProduct']['total_amount']	= $val['amount'];
									$this->PurchaseProduct->saveAll($sale_products);
								}
							}
							
							$this->Session->setFlash(__('Purchase has been saved successfully.'), 'admin_flash_success');
							$this->redirect(array('action' => 'index'));
							} else {
							$this->Session->setFlash(__('Purchase could not be saved. Please try again.'), 'admin_flash_error');
						}
						}else {
						$this->Session->setFlash('Purchase could not be saved. Please correct errors.', 'admin_flash_error');
					}
				}
			}else{
				$this->request->data['Purchase']['order_date'] = date('Y-m-d');
				$this->request->data['Purchase']['order_no'] = "PO-". date('dmy') .'-'. $this->Purchase->nextCode();
			}
			
			$users = $this->User->find('list', array('fields'=>array('User.id', 'User.name'), 'conditions'=>array('User.role_id'=>3, 'User.status'=>1), 'order'=>array('User.first_name'=>'ASC')));
			$this->set(compact('users')) ;
		}
		
		
		
		
		public function admin_edit($id = null) {
			$this->set('title_for_layout',  __('Update Purchases Information', true)) ;
			$this->Purchase->id = $id;
			
			if (!$this->Purchase->exists()) {
				throw new NotFoundException(__('Invalid Admin'));
			}
			
			if ($this->request->is('post') || $this->request->is('put')) {	
			
				//pr($this->request->data); die; 
			
				if(!empty($this->request->data)) {
					if (!isset($this->request->params['data']['_Token']['key']) || ($this->request->params['data']['_Token']['key'] != $this->request->params['_Token']['key'])) {
						$blackHoleCallback = $this->Security->blackHoleCallback;
						$this->$blackHoleCallback();
					}
					
					//validate Purchase data
					$this->Purchase->set($this->request->data);
					$this->Purchase->setValidation('admin');
					if ($this->Purchase->validates()){
					
						$items = (isset($this->request->data['Purchase']['p']))?$this->request->data['Purchase']['p']:'';
						unset($this->request->data['Purchase']['p']);
						
						$deliver_to = isset($this->request->data['Purchase']['deliver_to'])?$this->request->data['Purchase']['deliver_to']:'';
						if($deliver_to==2) {
							$customer_id = $this->request->data['Purchase']['customer_id'];
						} else {
							$customer_id = $this->Auth->user('id');
						} 
						$this->request->data['Purchase']['deliver_type'] = $deliver_to;
						$this->request->data['Purchase']['deliver_to'] = $customer_id;  
					
						if ($this->Purchase->saveAll($this->request->data)) { 
							$purchase_id = $id;
							if($items){
								$this->loadModel('PurchaseProduct');
								$this->PurchaseProduct->deleteAll(array('PurchaseProduct.purchase_id'=>$id));
								foreach($items as $val){
									$sale_products = array();
									$sale_products['PurchaseProduct']['product_id']		= $val['product_id'];
									$sale_products['PurchaseProduct']['purchase_id']	= $purchase_id;
									$sale_products['PurchaseProduct']['qty']			= $val['quantity'];
									$sale_products['PurchaseProduct']['rate']			= $val['rate'];
									$sale_products['PurchaseProduct']['discount']		= $val['discount'];
									$sale_products['PurchaseProduct']['tax']			= $val['tax'];
									$sale_products['PurchaseProduct']['total_amount']	= $val['amount'];
									$this->PurchaseProduct->saveAll($sale_products);
								}
							} 
							$this->Session->setFlash(__('Purchase information has been updated successfully.',true), 'admin_flash_success');
							$this->redirect(array('action'=>'index')) ;
						} else {
							$this->Session->setFlash(__('Purchase could not be updated. Please try again.',true), 'admin_flash_error');
						}
					}else {
						$this->Session->setFlash(__('Purchase could not be updated. Please correct errors.', true), 'admin_flash_error');
					}
				}	
			} else {		
				$this->Purchase->id = $id;
				$this->Purchase->bindModel(array('belongsTo'=>array('User')), false);
				$this->request->data = $this->Purchase->read(null, $id); 
			}
			
			$users 	= $this->User->find('list', array('fields'=>array('User.id', 'User.name'), 'conditions'=>array('User.role_id'=>3, 'User.status'=>1), 'order'=>array('User.first_name'=>'ASC')));
			$this->set(compact('users')) ;
		}
		
		
		
	    public function admin_delete($id = null){
			$this->Purchase->id = $id;
			if (!$this->Purchase->exists()) {
				throw new NotFoundException(__('Invalid Purchase'));
			}
			
			if (!isset($this->request->params['named']['token']) || ($this->request->params['named']['token'] != $this->request->params['_Token']['key'])) {
				$blackHoleCallback = $this->Security->blackHoleCallback;
				$this->$blackHoleCallback();
			}
			
			$data['Purchase']['id'] =  $id;
			$data['Purchase']['status'] =  5;
			if ($this->Purchase->saveAll($data)) {
				$this->Session->setFlash(__('Purchase has been deleted successfully.'), 'admin_flash_success');
				$this->redirect(array('controller' => 'products', 'action' =>'index'));			
				}else{
				$this->Session->setFlash(__('Purchase could not be deleted.'), 'admin_flash_error');
				$this->redirect(array('controller' => 'products', 'action' =>'index'));
			}
		}
		
		
		
		public function admin_status($id = null) {
			
			$this->Purchase->id = $id;
			if (!$this->Purchase->exists()) {
				throw new NotFoundException(__('Invalid Purchase'));
			}
			
			if (!isset($this->request->params['named']['token']) || ($this->request->params['named']['token'] != $this->request->params['_Token']['key'])) {
				$blackHoleCallback = $this->Security->blackHoleCallback;
				$this->$blackHoleCallback();
			}
			
			if ($this->Purchase->toggleStatus($id)) {
				$this->Session->setFlash(__('Purchase  status has been changed.'), 'admin_flash_success');
				$this->redirect($this->referer());
			}
			$this->Session->setFlash(__('Purchase status could not be changed.', 'admin_flash_error'));
			$this->redirect($this->referer());
		}
		
		
		
		public function admin_view($id = null) {
			$this->set('title_for_layout',  __('Purchase Information', true)) ;
			$result = array();
			
			$this->Purchase->id = $id;
			if (!$this->Purchase->exists()) {
				throw new NotFoundException(__('Invalid Purchase'));
			}
			
			$this->Purchase->bindModel(array('belongsTo'=>array('User')), false);
			$this->set('data', $this->Purchase->read(null, $id));
		}
		
		

		/*
			** List all products in admin panel
		*/
		public function admin_report($defaultTab=null){ 
			$this->set('title_for_layout',  __('Reports', true)) ;
		}
		
/*
			** List all products in admin panel
		*/
		public function admin_purchase_order_history_report($defaultTab=null){
		
			
			$this->set('title_for_layout',  __('Purchase Order Report', true)) ;
			if(!isset($this->request->params['named']['page']) and !isset($this->request->params['named']['sort'])){
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
			}	
			
			$filters = array();
			if($defaultTab){
				$filters 		  = array('Purchase.status'=>$defaultTab);
				$title_for_layout = "Purchases Order Listing (". Configure::read('PurchasesStatus.'. $defaultTab) .")";
				$this->Session->write('Url.defaultTab', $defaultTab);
			}
			
			if(!empty($this->request->data)){ 
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
				
				App::uses('Sanitize', 'Utility');		
				if(!empty($this->data['Purchase']['status'])){				
					$status = Sanitize::escape($this->request->data['Purchase']['status']);
					$this->Session->write('AdminSearch.status', $status);				
				}
				if(!empty($this->data['Purchase']['from'])){				
					$from = Sanitize::escape($this->request->data['Purchase']['from']);
					$this->Session->write('AdminSearch.from', $from);				
				}
				if(!empty($this->data['Purchase']['to'])){				
					$to = Sanitize::escape($this->request->data['Purchase']['to']);
					$this->Session->write('AdminSearch.to', $to);				
				}
			} 
			
			$date_from = '';
			$date_to = '';
			if($this->Session->check('AdminSearch.status')){
				$status  = $this->Session->read('AdminSearch.status');			
				$filters[] = array('Purchase.status'=> $status);
			} 
			
			if($this->Session->check('AdminSearch.from')){
				$date_from  = $this->Session->read('AdminSearch.from'); 
			} 
			
			if($this->Session->check('AdminSearch.to')){
				$date_to  = $this->Session->read('AdminSearch.to');		 
			} 
			
			if($date_from!='' and $date_to!=''){
				$filters[] = array('Purchase.created BETWEEN ? AND ?' => array($date_from, $date_to));
			}else if($date_from!=''){
				$filters[] = array('Purchase.created >= '=> $date_from);
			}else if($date_to!=''){
				$filters[] = array('Purchase.created <= '=> $date_to);
			} 

			$this->Purchase->bindModel(array(
				//'hasMany'=>array('PurchaseProduct'=>array('className' => 'PurchaseProduct')),
				'belongsTo'=>array('User'=>array('className' => 'User')),
			),false);
			
			$this->paginate = array(
				'Purchase'	=> array(
				'fields'			=> array('Purchase.*', 'User.first_name', 'User.last_name'),
				'limit'				=> Configure::read('App.AdminPageLimit'), 
				'order'				=> array('Purchase.modified'=>'DESC'),
				'conditions'		=> $filters
			));
			 
			$data 	= $this->paginate('Purchase');    
			$this->set(compact('data'));	
			
		}


		/*
			** List all products in admin panel
		*/
		public function admin_purchase_order_history_report_receive($defaultTab=1){
		
			
			$this->set('title_for_layout',  __('Purchase Recive Order Report', true)) ;
			if(!isset($this->request->params['named']['page']) and !isset($this->request->params['named']['sort'])){
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
			}	
			
			$filters = array();
			if($defaultTab){
				$filters 		  = array('Purchase.status'=>$defaultTab);
				$title_for_layout = "Purchases Order Listing (". Configure::read('PurchasesStatus.'. $defaultTab) .")";
				$this->Session->write('Url.defaultTab', $defaultTab);
			}
			
			if(!empty($this->request->data)){ 
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
				
				App::uses('Sanitize', 'Utility');		
				if(!empty($this->data['Purchase']['status'])){				
					$status = Sanitize::escape($this->request->data['Purchase']['status']);
					$this->Session->write('AdminSearch.status', $status);				
				}
				if(!empty($this->data['Purchase']['from'])){				
					$from = Sanitize::escape($this->request->data['Purchase']['from']);
					$this->Session->write('AdminSearch.from', $from);				
				}
				if(!empty($this->data['Purchase']['to'])){				
					$to = Sanitize::escape($this->request->data['Purchase']['to']);
					$this->Session->write('AdminSearch.to', $to);				
				}
			} 
			
			$date_from = '';
			$date_to = '';
			if($this->Session->check('AdminSearch.status')){
				$status  = $this->Session->read('AdminSearch.status');			
				$filters[] = array('Purchase.status'=> $status);
			} 
			
			if($this->Session->check('AdminSearch.from')){
				$date_from  = $this->Session->read('AdminSearch.from'); 
			} 
			
			if($this->Session->check('AdminSearch.to')){
				$date_to  = $this->Session->read('AdminSearch.to');		 
			} 
			
			if($date_from!='' and $date_to!=''){
				$filters[] = array('Purchase.created BETWEEN ? AND ?' => array($date_from, $date_to));
			}else if($date_from!=''){
				$filters[] = array('Purchase.created >= '=> $date_from);
			}else if($date_to!=''){
				$filters[] = array('Purchase.created <= '=> $date_to);
			} 

			$this->Purchase->bindModel(array(
				'hasMany'=>array('PurchaseProduct'=>array('className' => 'PurchaseProduct')),
				'belongsTo'=>array('User'=>array('className' => 'User')),
			),false);
			
			$this->paginate = array(
				'Purchase'	=> array(
				//'fields'			=> array('Purchase.*', 'User.first_name', 'User.last_name'),
				'limit'				=> Configure::read('App.AdminPageLimit'), 
				'order'				=> array('Purchase.modified'=>'DESC'),
				'conditions'		=> $filters
			));
			 
			$data 	= $this->paginate('Purchase');    
			//pr($data);die;
			$this->set(compact('data'));	
			
		}
	  
	
		public function admin_export_pdf() {
		
			$this->loadModel('PurchaseProduct'); 
			$filters = array();
			$postData = array();
			if($this->Session->check('AdminSearch')){
				$from_date  = $this->Session->read('AdminSearch.from');
				$to_date  	= $this->Session->read('AdminSearch.to');
				$status	= $this->Session->read('AdminSearch.status');
				
				if($this->Session->check('AdminSearch.status')){ 
					$filters[]	= array('Purchase.status'=>$status);
				} 
				if($from_date and $to_date){
					$filters[] = array('Purchase.created BETWEEN ? AND ?'=> array($from_date, $to_date));
				}else if($from_date){
					$filters[] = array('Purchase.created >=' => $from_date);
				}else if($to_date){
					$filters[] = array('Purchase.created <=' => $to_date);
				} 
			}
			
			$this->Purchase->bindModel(array('belongsTo'=>array('User')), false);
			$data = $this->Purchase->find('all', array(  
				'conditions'=> $filters,
				'fields'=>array('Purchase.*', 'User.first_name', 'User.last_name'),
				'order'	=> array('Purchase.modified'=>'DESC'),
			));  
			
			$all_total_amt = 0;
			$all_total_qty = 0;
			$last_key= '';  
			foreach($data as $key => $p){
			
				$sale_product = $this->PurchaseProduct->find('all', array(  
					'conditions'=>array('PurchaseProduct.purchase_id'=>$p['Purchase']['id'])
				));   
				$total_amt = 0;
				$total_qty = 0;
				if(!empty($sale_product)) {
					foreach($sale_product as $val) {
						$total_amt +=  $val['PurchaseProduct']['total_amount']; 
						$total_qty +=  $val['PurchaseProduct']['qty']; 
					}
				}  
				
				$postData[$key]['Post']['date'] = $p['Purchase']['date'];
				$postData[$key]['Post']['order_no'] = $p['Purchase']['order_no'];
				$postData[$key]['Post']['vendor'] = $p['User']['first_name'] .' '. $p['User']['last_name']; 
				$postData[$key]['Post']['reference'] = $p['Purchase']['reference']; 
				$postData[$key]['Post']['expected_delivery_date'] = $p['Purchase']['expected_delivery_date'];
				$postData[$key]['Post']['status'] = Configure::read('SalesStatus.' . $p['Purchase']['status']); 
				$postData[$key]['Post']['qty_qrdered'] =  $total_qty;
				$postData[$key]['Post']['amount'] =  number_format($total_amt,2);
				 
				$all_total_qty += $total_qty; 
				$all_total_amt += $total_amt; 
				
				$last_key += $key;

			}    
			
			if(!empty($postData)){
				$last_key = $last_key+1;
				$postData[$last_key]['Post']['date'] = 'Total';
				$postData[$last_key]['Post']['order_no'] = '';
				$postData[$last_key]['Post']['vendor'] = '';
				$postData[$last_key]['Post']['reference'] = '';
				$postData[$last_key]['Post']['shipment_data'] = '';
				$postData[$last_key]['Post']['status'] = $all_total_qty;
				$postData[$last_key]['Post']['amount'] =  number_format($all_total_amt,2);  
			}  
			
			//pr($postData); die;
			  
			$this->set('posts',$postData);   
			$html_content = '<div class="pageheader" style="margin-bottom: 3px; text-align: center;">
				<h2 class="custom-font">'.$this->Auth->user('company_name').'</h2>
				<p>Purchase Order History</p>
			</div>'; 
			$view = new View($this, false);
			$html_content .= $view->element('Admin/Purchase/purchase_report_pdf');	
			
			//pr($html_content); die; 
			
			App::import('Vendor', 'mPDF', array('file'=>'mpdf/mpdf.php')); 
			$mpdf = new mPDF(); 
			$mpdf->setAutoTopMargin = 'stretch'; // Set pdf top margin to stretch to avoid content overlapping  
			$mpdf->WriteHTML($html_content);
			$mpdf->Output('purchaseorder_details.pdf','D');
			die;
			
		}
		
		
		public function admin_export_csv() { 
		
		  	$this->loadModel('PurchaseProduct'); 
			$filters = array();
			$postData = array();
			if($this->Session->check('AdminSearch')){
				$from_date  = $this->Session->read('AdminSearch.from');
				$to_date  	= $this->Session->read('AdminSearch.to');
				$status	= $this->Session->read('AdminSearch.status');
				
				if($this->Session->check('AdminSearch.status')){ 
					$filters[]	= array('Purchase.status'=>$status);
				} 
				if($from_date and $to_date){
					$filters[] = array('Purchase.created BETWEEN ? AND ?'=> array($from_date, $to_date));
				}else if($from_date){
					$filters[] = array('Purchase.created >=' => $from_date);
				}else if($to_date){
					$filters[] = array('Purchase.created <=' => $to_date);
				} 
			}
			
			$this->Purchase->bindModel(array('belongsTo'=>array('User')), false);
			$data = $this->Purchase->find('all', array(  
				'conditions'=> $filters,
				'fields'=>array('Purchase.*', 'User.first_name', 'User.last_name'),
				'order'	=> array('Purchase.modified'=>'DESC'),
			));  
			
			$all_total_amt = 0;
			$all_total_qty = 0;
			$last_key= '';  
			foreach($data as $key => $p){
			
				$sale_product = $this->PurchaseProduct->find('all', array(  
					'conditions'=>array('PurchaseProduct.purchase_id'=>$p['Purchase']['id'])
				));   
				$total_amt = 0;
				$total_qty = 0;
				if(!empty($sale_product)) {
					foreach($sale_product as $val) {
						$total_amt +=  $val['PurchaseProduct']['total_amount']; 
						$total_qty +=  $val['PurchaseProduct']['qty']; 
					}
				}  
				
				$postData[$key]['Post']['date'] = $p['Purchase']['date'];
				$postData[$key]['Post']['order_no'] = $p['Purchase']['order_no'];
				$postData[$key]['Post']['vendor'] = $p['User']['first_name'] .' '. $p['User']['last_name']; 
				$postData[$key]['Post']['reference'] = $p['Purchase']['reference']; 
				$postData[$key]['Post']['expected_delivery_date'] = $p['Purchase']['expected_delivery_date'];
				$postData[$key]['Post']['status'] = Configure::read('SalesStatus.' . $p['Purchase']['status']); 
				$postData[$key]['Post']['qty_qrdered'] =  $total_qty;
				$postData[$key]['Post']['amount'] =  number_format($total_amt,2);
				 
				$all_total_qty += $total_qty; 
				$all_total_amt += $total_amt; 
				
				$last_key += $key;

			}    
			
			if(!empty($postData)){
				$last_key = $last_key+1;
				$postData[$last_key]['Post']['date'] = 'Total';
				$postData[$last_key]['Post']['order_no'] = '';
				$postData[$last_key]['Post']['vendor'] = '';
				$postData[$last_key]['Post']['reference'] = '';
				$postData[$last_key]['Post']['expected_delivery_date'] = '';
				$postData[$last_key]['Post']['status'] = '';
				$postData[$last_key]['Post']['qty_qrdered'] = $all_total_qty;
				$postData[$last_key]['Post']['amount'] =  number_format($all_total_amt,2);  
			}  
			
			$file_name = 'purchaseorder_details'; 
			$this->set('posts',$postData);
			$this->layout = null;
			$this->autoLayout = false; 
			
		}
		
		
		
		
		
		public function admin_export_xls(){
		
			$this->autoRender = false;

		  	$this->loadModel('PurchaseProduct'); 
			$filters = array();
			$postData = array();
			if($this->Session->check('AdminSearch')){
				$from_date  = $this->Session->read('AdminSearch.from');
				$to_date  	= $this->Session->read('AdminSearch.to');
				$status	= $this->Session->read('AdminSearch.status');
				
				if($this->Session->check('AdminSearch.status')){ 
					$filters[]	= array('Purchase.status'=>$status);
				} 
				if($from_date and $to_date){
					$filters[] = array('Purchase.created BETWEEN ? AND ?'=> array($from_date, $to_date));
				}else if($from_date){
					$filters[] = array('Purchase.created >=' => $from_date);
				}else if($to_date){
					$filters[] = array('Purchase.created <=' => $to_date);
				} 
			}
			
			$this->Purchase->bindModel(array('belongsTo'=>array('User')), false);
			$data = $this->Purchase->find('all', array(  
				'conditions'=> $filters,
				'fields'=>array('Purchase.*', 'User.first_name', 'User.last_name'),
				'order'	=> array('Purchase.modified'=>'DESC'),
			));  
			
			$all_total_amt = 0;
			$all_total_qty = 0;
			$last_key= '';  
			foreach($data as $key => $p){
			
				$sale_product = $this->PurchaseProduct->find('all', array(  
					'conditions'=>array('PurchaseProduct.purchase_id'=>$p['Purchase']['id'])
				));   
				$total_amt = 0;
				$total_qty = 0;
				if(!empty($sale_product)) {
					foreach($sale_product as $val) {
						$total_amt +=  $val['PurchaseProduct']['total_amount']; 
						$total_qty +=  $val['PurchaseProduct']['qty']; 
					}
				}  
				
				$postData[$key]['date'] = $p['Purchase']['date'];
				$postData[$key]['order_no'] = $p['Purchase']['order_no'];
				$postData[$key]['vendor'] = $p['User']['first_name'] .' '. $p['User']['last_name']; 
				$postData[$key]['reference'] = $p['Purchase']['reference']; 
				$postData[$key]['expected_delivery_date'] = $p['Purchase']['expected_delivery_date'];
				$postData[$key]['status'] = Configure::read('SalesStatus.' . $p['Purchase']['status']); 
				$postData[$key]['qty_qrdered'] =  $total_qty;
				$postData[$key]['amount'] =  number_format($total_amt,2);
				 
				$all_total_qty += $total_qty; 
				$all_total_amt += $total_amt; 
				
				$last_key += $key;

			}    
			
			if(!empty($postData)){
				$last_key = $last_key+1;
				$postData[$last_key]['date'] = 'Total';
				$postData[$last_key]['order_no'] = '';
				$postData[$last_key]['vendor'] = '';
				$postData[$last_key]['reference'] = '';
				$postData[$last_key]['expected_delivery_date'] = '';
				$postData[$last_key]['status'] = '';
				$postData[$last_key]['qty_qrdered'] = $all_total_qty;
				$postData[$last_key]['amount'] =  number_format($all_total_amt,2);  
			}  			
			//pr($postData); die; 
			$name =  "purchase_order_details";
			$this->Common->createExcelFile($postData,'Excel',$name);
		} 
		
		
		
		function referer($default = NULL, $local = false){
			$defaultTab = $this->Session->read('Url.defaultTab');
			$Page = $this->Session->read('Url.Page');
			$sort = $this->Session->read('Url.sort');
			$direction = $this->Session->read('Url.direction');
			
			return Router::url(array('action'=>'index', $defaultTab,'Page'=>$Page,'sort'=>$sort,'direction'=>$direction),true);
		}

		function admin_inventory_details(){
				$this->loadModel('Product'); 
			$filters = array();
			$postData = array();
			$this->set('title_for_layout',  __('Inventory Details', true)) ;
			if(!isset($this->request->params['named']['page']) and !isset($this->request->params['named']['sort'])){
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
			}	
			
			if($this->Session->check('AdminSearch')){
				$from_date  = $this->Session->read('AdminSearch.from');
				$to_date  	= $this->Session->read('AdminSearch.to');
				$status	= $this->Session->read('AdminSearch.status');
				
				if($this->Session->check('AdminSearch.status')){ 
					$filters[]	= array('Product.status'=>$status);
				} 
				if($from_date and $to_date){
					$filters[] = array('Product.created BETWEEN ? AND ?'=> array($from_date, $to_date));
				}else if($from_date){
					$filters[] = array('Product.created >=' => $from_date);
				}else if($to_date){
					$filters[] = array('Product.created <=' => $to_date);
				} 
			}
			
			$this->Product->bindModel(array('belongsTo'=>array('User')), false);
			
			
			$this->paginate = array(
				'Product'	=> array(
				'fields'			=> array('Product.*', 'User.first_name', 'User.last_name'),
				'limit'				=> Configure::read('App.AdminPageLimit'), 
				'order'				=> array('Product.modified'=>'DESC'),
				'conditions'		=> $filters
			));
			 
			$data 	= $this->paginate('Product');    
			//pr($data);die;
			$this->set(compact('data'));	
		}

		public function admin_product_export_pdf() {
		
			$this->loadModel('Product'); 
			$filters = array();
			$postData = array();
			if($this->Session->check('AdminSearch')){
				$from_date  = $this->Session->read('AdminSearch.from');
				$to_date  	= $this->Session->read('AdminSearch.to');
				$status	= $this->Session->read('AdminSearch.status');
				
				if($this->Session->check('AdminSearch.status')){ 
					$filters[]	= array('Product.status'=>$status);
				} 
				if($from_date and $to_date){
					$filters[] = array('Product.created BETWEEN ? AND ?'=> array($from_date, $to_date));
				}else if($from_date){
					$filters[] = array('Product.created >=' => $from_date);
				}else if($to_date){
					$filters[] = array('Product.created <=' => $to_date);
				} 
			}
			
			$this->Product->bindModel(array('belongsTo'=>array('User')), false);
			$data = $this->Product->find('all', array(  
				'conditions'=> $filters,
				'fields'=>array('Product.*', 'User.first_name', 'User.last_name'),
				'order'	=> array('Product.modified'=>'DESC'),
			));  
			
			$all_total_amt = 0;
			$all_total_qty = 0;
			$last_key= '';  
			foreach($data as $key => $p){
			
				
				
				$postData[$key]['Post']['date'] = $p['Product']['name'];
				$postData[$key]['Post']['order_no'] = $p['Purchase']['order_no'];
				$postData[$key]['Post']['vendor'] = $p['User']['first_name'] .' '. $p['User']['last_name']; 
				$postData[$key]['Post']['reference'] = $p['Purchase']['reference']; 
				$postData[$key]['Post']['expected_delivery_date'] = $p['Purchase']['expected_delivery_date'];
				$postData[$key]['Post']['status'] = Configure::read('SalesStatus.' . $p['Purchase']['status']); 
				$postData[$key]['Post']['qty_qrdered'] =  $total_qty;
				$postData[$key]['Post']['amount'] =  number_format($total_amt,2);
				 
				$all_total_qty += $total_qty; 
				$all_total_amt += $total_amt; 
				
				$last_key += $key;

			}    
			
			if(!empty($postData)){
				$last_key = $last_key+1;
				$postData[$last_key]['Post']['date'] = 'Total';
				$postData[$last_key]['Post']['order_no'] = '';
				$postData[$last_key]['Post']['vendor'] = '';
				$postData[$last_key]['Post']['reference'] = '';
				$postData[$last_key]['Post']['shipment_data'] = '';
				$postData[$last_key]['Post']['status'] = $all_total_qty;
				$postData[$last_key]['Post']['amount'] =  number_format($all_total_amt,2);  
			}  
			
			//pr($postData); die;
			  
			$this->set('posts',$postData);   
			$html_content = '<div class="pageheader" style="margin-bottom: 3px; text-align: center;">
				<h2 class="custom-font">'.$this->Auth->user('company_name').'</h2>
				<p>Purchase Order History</p>
			</div>'; 
			$view = new View($this, false);
			$html_content .= $view->element('Admin/Purchase/purchase_report_pdf');	
			
			//pr($html_content); die; 
			
			App::import('Vendor', 'mPDF', array('file'=>'mpdf/mpdf.php')); 
			$mpdf = new mPDF(); 
			$mpdf->setAutoTopMargin = 'stretch'; // Set pdf top margin to stretch to avoid content overlapping  
			$mpdf->WriteHTML($html_content);
			$mpdf->Output('purchaseorder_details.pdf','D');
			die;
			
		}
		
		
		public function admin_product_export_csv() { 
		
		  	$this->loadModel('PurchaseProduct'); 
			$filters = array();
			$postData = array();
			if($this->Session->check('AdminSearch')){
				$from_date  = $this->Session->read('AdminSearch.from');
				$to_date  	= $this->Session->read('AdminSearch.to');
				$status	= $this->Session->read('AdminSearch.status');
				
				if($this->Session->check('AdminSearch.status')){ 
					$filters[]	= array('Purchase.status'=>$status);
				} 
				if($from_date and $to_date){
					$filters[] = array('Purchase.created BETWEEN ? AND ?'=> array($from_date, $to_date));
				}else if($from_date){
					$filters[] = array('Purchase.created >=' => $from_date);
				}else if($to_date){
					$filters[] = array('Purchase.created <=' => $to_date);
				} 
			}
			
			$this->Purchase->bindModel(array('belongsTo'=>array('User')), false);
			$data = $this->Purchase->find('all', array(  
				'conditions'=> $filters,
				'fields'=>array('Purchase.*', 'User.first_name', 'User.last_name'),
				'order'	=> array('Purchase.modified'=>'DESC'),
			));  
			
			$all_total_amt = 0;
			$all_total_qty = 0;
			$last_key= '';  
			foreach($data as $key => $p){
			
				$sale_product = $this->PurchaseProduct->find('all', array(  
					'conditions'=>array('PurchaseProduct.purchase_id'=>$p['Purchase']['id'])
				));   
				$total_amt = 0;
				$total_qty = 0;
				if(!empty($sale_product)) {
					foreach($sale_product as $val) {
						$total_amt +=  $val['PurchaseProduct']['total_amount']; 
						$total_qty +=  $val['PurchaseProduct']['qty']; 
					}
				}  
				
				$postData[$key]['Post']['date'] = $p['Purchase']['date'];
				$postData[$key]['Post']['order_no'] = $p['Purchase']['order_no'];
				$postData[$key]['Post']['vendor'] = $p['User']['first_name'] .' '. $p['User']['last_name']; 
				$postData[$key]['Post']['reference'] = $p['Purchase']['reference']; 
				$postData[$key]['Post']['expected_delivery_date'] = $p['Purchase']['expected_delivery_date'];
				$postData[$key]['Post']['status'] = Configure::read('SalesStatus.' . $p['Purchase']['status']); 
				$postData[$key]['Post']['qty_qrdered'] =  $total_qty;
				$postData[$key]['Post']['amount'] =  number_format($total_amt,2);
				 
				$all_total_qty += $total_qty; 
				$all_total_amt += $total_amt; 
				
				$last_key += $key;

			}    
			
			if(!empty($postData)){
				$last_key = $last_key+1;
				$postData[$last_key]['Post']['date'] = 'Total';
				$postData[$last_key]['Post']['order_no'] = '';
				$postData[$last_key]['Post']['vendor'] = '';
				$postData[$last_key]['Post']['reference'] = '';
				$postData[$last_key]['Post']['expected_delivery_date'] = '';
				$postData[$last_key]['Post']['status'] = '';
				$postData[$last_key]['Post']['qty_qrdered'] = $all_total_qty;
				$postData[$last_key]['Post']['amount'] =  number_format($all_total_amt,2);  
			}  
			
			$file_name = 'purchaseorder_details'; 
			$this->set('posts',$postData);
			$this->layout = null;
			$this->autoLayout = false; 
			
		}
		
		
		
		
		
		public function admin_product_export_xls(){
		
			$this->autoRender = false;

		  	$this->loadModel('PurchaseProduct'); 
			$filters = array();
			$postData = array();
			if($this->Session->check('AdminSearch')){
				$from_date  = $this->Session->read('AdminSearch.from');
				$to_date  	= $this->Session->read('AdminSearch.to');
				$status	= $this->Session->read('AdminSearch.status');
				
				if($this->Session->check('AdminSearch.status')){ 
					$filters[]	= array('Purchase.status'=>$status);
				} 
				if($from_date and $to_date){
					$filters[] = array('Purchase.created BETWEEN ? AND ?'=> array($from_date, $to_date));
				}else if($from_date){
					$filters[] = array('Purchase.created >=' => $from_date);
				}else if($to_date){
					$filters[] = array('Purchase.created <=' => $to_date);
				} 
			}
			
			$this->Purchase->bindModel(array('belongsTo'=>array('User')), false);
			$data = $this->Purchase->find('all', array(  
				'conditions'=> $filters,
				'fields'=>array('Purchase.*', 'User.first_name', 'User.last_name'),
				'order'	=> array('Purchase.modified'=>'DESC'),
			));  
			
			$all_total_amt = 0;
			$all_total_qty = 0;
			$last_key= '';  
			foreach($data as $key => $p){
			
				$sale_product = $this->PurchaseProduct->find('all', array(  
					'conditions'=>array('PurchaseProduct.purchase_id'=>$p['Purchase']['id'])
				));   
				$total_amt = 0;
				$total_qty = 0;
				if(!empty($sale_product)) {
					foreach($sale_product as $val) {
						$total_amt +=  $val['PurchaseProduct']['total_amount']; 
						$total_qty +=  $val['PurchaseProduct']['qty']; 
					}
				}  
				
				$postData[$key]['date'] = $p['Purchase']['date'];
				$postData[$key]['order_no'] = $p['Purchase']['order_no'];
				$postData[$key]['vendor'] = $p['User']['first_name'] .' '. $p['User']['last_name']; 
				$postData[$key]['reference'] = $p['Purchase']['reference']; 
				$postData[$key]['expected_delivery_date'] = $p['Purchase']['expected_delivery_date'];
				$postData[$key]['status'] = Configure::read('SalesStatus.' . $p['Purchase']['status']); 
				$postData[$key]['qty_qrdered'] =  $total_qty;
				$postData[$key]['amount'] =  number_format($total_amt,2);
				 
				$all_total_qty += $total_qty; 
				$all_total_amt += $total_amt; 
				
				$last_key += $key;

			}    
			
			if(!empty($postData)){
				$last_key = $last_key+1;
				$postData[$last_key]['date'] = 'Total';
				$postData[$last_key]['order_no'] = '';
				$postData[$last_key]['vendor'] = '';
				$postData[$last_key]['reference'] = '';
				$postData[$last_key]['expected_delivery_date'] = '';
				$postData[$last_key]['status'] = '';
				$postData[$last_key]['qty_qrdered'] = $all_total_qty;
				$postData[$last_key]['amount'] =  number_format($all_total_amt,2);  
			}  			
			//pr($postData); die; 
			$name =  "purchase_order_details";
			$this->Common->createExcelFile($postData,'Excel',$name);
		} 


	}	