<?php
	/**
		* Sales Controller
		*
		* PHP version 5.4
		*
	*/
	class SalesController  extends AppController {
		/**
			* Controller name
			*
			* @var string
			* @access public
		*/
		public $components = array('Common');
		var	$name	= 'Sales'; 
		var	$uses	=	array('Sale', 'User', 'Category');
		
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
				$this->render('/Elements/Admin/Sale/add_product');
				} else{
				die;
			}
		}
		
		
		
		
		
		
		/*
			** List all products in admin panel
		*/
		public function admin_index($defaultTab=null){
			
			$this->set('title_for_layout',  __('Sales Order Listing', true)) ;
			if(!isset($this->request->params['named']['page']) and !isset($this->request->params['named']['sort'])){
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
			}	
			
			$filters = array();
			if($defaultTab){
				$filters 		  = array('Sale.status'=>$defaultTab);
				$title_for_layout = "Sales Order Listing (". Configure::read('SalesStatus.'. $defaultTab) .")";
				$this->Session->write('Url.defaultTab', $defaultTab);
			}
			
			if(!empty($this->request->data)){			
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
				
				App::uses('Sanitize', 'Utility');		
				if(!empty($this->data['Sale']['keyword'])){				
					$name = Sanitize::escape($this->request->data['Sale']['keyword']);
					$this->Session->write('AdminSearch.keyword', $name);				
				}
			}
			
			if($this->Session->check('AdminSearch')){
				$keyword  = $this->Session->read('AdminSearch.keyword');			
				$filters[] = array('OR'=>array('Sale.order_no LIKE'=>$keyword."%", 'User.first_name LIKE'=>$keyword."%", 'User.last_name LIKE'=>$keyword."%"));
			}
			
			$this->Sale->bindModel(array('belongsTo'=>array('User')), false);
			$this->paginate = array(
			'Sale'	=> array(
			'fields'			=> array('Sale.*', 'User.first_name', 'User.last_name'),
			'limit'				=> Configure::read('App.AdminPageLimit'), 
			'order'				=> array('Product.modified'=>'DESC'),
			'conditions'		=> $filters
			));
			
			$data 		= $this->paginate('Sale');   
     		$new     	= $this->Sale->find('count',array('conditions'=>array('Sale.status'=>1)));
			$packed 	= $this->Sale->find('count',array('conditions'=>array('Sale.status'=>2)));
			$dispached 	= $this->Sale->find('count',array('conditions'=>array('Sale.status'=>3)));
			$delivered 	= $this->Sale->find('count',array('conditions'=>array('Sale.status'=>4)));
			$canceled 	= $this->Sale->find('count',array('conditions'=>array('Sale.status'=>5)));
			$returned 	= $this->Sale->find('count',array('conditions'=>array('Sale.status'=>6)));
			$all		= (int)$new + (int)$packed + (int)$dispached + (int)$delivered + (int)$canceled + (int)$returned; 
			$this->set(compact('data','new','packed','dispached','delivered','canceled','returned','all'));		
		}
		
		
		public function admin_sales_order_history_report() {
		
			$this->set('title_for_layout',  __('Sales Order Report', true)) ;
			if(!isset($this->request->params['named']['page']) and !isset($this->request->params['named']['sort'])){
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
			}	
			
			$filters = array(); 
			$title_for_layout = "Sales Order Report";  
			
			if(!empty($this->request->data)){		
			
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
				
				App::uses('Sanitize', 'Utility');		
				if(!empty($this->data['Sale']['status'])){				
					$status = Sanitize::escape($this->request->data['Sale']['status']);
					$this->Session->write('AdminSearch.status', $status);				
				}
				
				if(!empty($this->data['Sale']['from'])){				
					$from = Sanitize::escape($this->request->data['Sale']['from']);
					$this->Session->write('AdminSearch.from', $from);				
				}
				
				if(!empty($this->data['Sale']['to'])){				
					$to = Sanitize::escape($this->request->data['Sale']['to']);
					$this->Session->write('AdminSearch.to', $to);				
				}
			}

			
			if($this->Session->check('AdminSearch')){
				$from_date  = $this->Session->read('AdminSearch.from');
				$to_date  	= $this->Session->read('AdminSearch.to');
				$status	= $this->Session->read('AdminSearch.status');
				
				if($keywords){
					$filters[]	= array('Sale.status'=>$status);
				}
				
				if($from_date and $to_date){
					$filters[] = array('Sale.created BETWEEN ? AND ?'=> array($from_date, $to_date));
				}else if($from_date){
					$filters[] = array('Sale.created >=' => $from_date);
				}else if($to_date){
					$filters[] = array('Sale.created <=' => $to_date);
				}
				
			}
			
			$this->Sale->bindModel(array('belongsTo'=>array('User')), false);
			$this->paginate = array(
			'Sale'	=> array(
			'fields'			=> array('Sale.*', 'User.first_name', 'User.last_name'),
			'limit'				=> Configure::read('App.AdminPageLimit'), 
			'order'				=> array('Sale.modified'=>'DESC'),
			'conditions'		=> $filters
			));
			
			$data 		= $this->paginate('Sale');    
			$this->set(compact('data'));	
			
			
		}
		
		
		
	
		public function admin_export_pdf() {
		
			$this->loadModel('SaleProduct'); 
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
					$filters[] = array('Sale.created BETWEEN ? AND ?'=> array($from_date, $to_date));
				}else if($from_date){
					$filters[] = array('Sale.created >=' => $from_date);
				}else if($to_date){
					$filters[] = array('Sale.created <=' => $to_date);
				} 
			}
			
			$this->Sale->bindModel(array('belongsTo'=>array('User')), false);
			$data = $this->Sale->find('all', array(  
				'conditions'=> $filters,
				'fields'=>array('Sale.*', 'User.first_name', 'User.last_name'),
				'order'	=> array('Sale.modified'=>'DESC'),
			));  
			
			$all_total_amt = 0;
			$last_key= '';  
			foreach($data as $key => $p){
			
				$sale_product = $this->SaleProduct->find('all', array(  
					'conditions'=>array('SaleProduct.sale_id'=>$p['Sale']['id'])
				));   
				$total_amt = 0;
				if(!empty($sale_product)) {
					foreach($sale_product as $val) {
						$total_amt +=  $val['SaleProduct']['total_amount']; 
					}
				}  
				
				$postData[$key]['Post']['date'] = $p['Sale']['order_date'];
				$postData[$key]['Post']['sale_order'] = $p['Sale']['order_no'];
				$postData[$key]['Post']['customer_name'] = $p['User']['first_name'] .' '. $p['User']['last_name']; 
				$postData[$key]['Post']['reference'] = $p['Sale']['reference']; 
				$postData[$key]['Post']['shipment_data'] = $p['Sale']['expected_shipping_date'];
				$postData[$key]['Post']['status'] = Configure::read('SalesStatus.' . $p['Sale']['status']); 
				$postData[$key]['Post']['amount'] =  number_format($total_amt,2);
				 
				$all_total_amt += $total_amt;  
				
				$last_key += $key;

			}    
			
			if(!empty($postData)){
				$last_key = $last_key+1;
				$postData[$last_key]['Post']['date'] = 'Total';
				$postData[$last_key]['Post']['sale_order'] = '';
				$postData[$last_key]['Post']['customer_name'] = '';
				$postData[$last_key]['Post']['reference'] = '';
				$postData[$last_key]['Post']['shipment_data'] = '';
				$postData[$last_key]['Post']['status'] = '';
				$postData[$last_key]['Post']['amount'] =  number_format($all_total_amt,2);  
			}  
			 
			  
			$this->set('posts',$postData);   
			$html_content = '<div class="pageheader" style="margin-bottom: 3px; text-align: center;">
				<h2 class="custom-font">'.$this->Auth->user('company_name').'</h2>
				<p>Sales Order History</p>
			</div>'; 
			$view = new View($this, false);
			$html_content .= $view->element('Admin/Sale/sale_report_pdf');	
			
			//pr($html_content); die; 
			
			App::import('Vendor', 'mPDF', array('file'=>'mpdf/mpdf.php')); 
			$mpdf = new mPDF(); 
			$mpdf->setAutoTopMargin = 'stretch'; // Set pdf top margin to stretch to avoid content overlapping  
			$mpdf->WriteHTML($html_content);
			$mpdf->Output('salesorder_details.pdf','D');
			die;
			
		}
		
		
		
		public function admin_export_csv() { 
		
			$this->loadModel('SaleProduct'); 
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
					$filters[] = array('Sale.created BETWEEN ? AND ?'=> array($from_date, $to_date));
				}else if($from_date){
					$filters[] = array('Sale.created >=' => $from_date);
				}else if($to_date){
					$filters[] = array('Sale.created <=' => $to_date);
				} 
			}
			
			$this->Sale->bindModel(array('belongsTo'=>array('User')), false);
			$data = $this->Sale->find('all', array(  
				'conditions'=> $filters,
				'fields'=>array('Sale.*', 'User.first_name', 'User.last_name'),
				'order'	=> array('Sale.modified'=>'DESC'),
			));  
			
			$all_total_amt = 0;
			$last_key= ''; 
			foreach($data as $key => $p){
			
				$sale_product = $this->SaleProduct->find('all', array(  
					'conditions'=>array('SaleProduct.sale_id'=>$p['Sale']['id'])
				));   
				$total_amt = 0;
				if(!empty($sale_product)) {
					foreach($sale_product as $val) {
						$total_amt +=  $val['SaleProduct']['total_amount']; 
					}
				}  
				
				$postData[$key]['Post']['date'] = $p['Sale']['order_date'];
				$postData[$key]['Post']['sale_order'] = $p['Sale']['order_no'];
				$postData[$key]['Post']['customer_name'] = $p['User']['first_name'] .' '. $p['User']['last_name']; 
				$postData[$key]['Post']['reference'] = $p['Sale']['reference']; 
				$postData[$key]['Post']['shipment_date'] = $p['Sale']['expected_shipping_date'];
				$postData[$key]['Post']['status'] = Configure::read('SalesStatus.' . $p['Sale']['status']); 
				$postData[$key]['Post']['amount'] =  number_format($total_amt,2);
				 
				$all_total_amt += $total_amt;  
				
				$last_key += $key;

			}    
			
			if(!empty($postData)){
				$last_key = $last_key+1;
				$postData[$last_key]['Post']['date'] = 'Total';
				$postData[$last_key]['Post']['sale_order'] = '';
				$postData[$last_key]['Post']['customer_name'] = '';
				$postData[$last_key]['Post']['reference'] = '';
				$postData[$last_key]['Post']['shipment_data'] = '';
				$postData[$last_key]['Post']['status'] = '';
				$postData[$last_key]['Post']['amount'] =  number_format($all_total_amt,2);  
			}  
			
			$file_name = 'salesorder_details'; 
			$this->set('posts',$postData);
			$this->layout = null;
			$this->autoLayout = false; 
			
		}
		
		
		
		
		
		public function admin_export_xls(){
		
			$this->autoRender = false;

			$this->loadModel('SaleProduct'); 
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
					$filters[] = array('Sale.created BETWEEN ? AND ?'=> array($from_date, $to_date));
				}else if($from_date){
					$filters[] = array('Sale.created >=' => $from_date);
				}else if($to_date){
					$filters[] = array('Sale.created <=' => $to_date);
				} 
			}
			
			$this->Sale->bindModel(array('belongsTo'=>array('User')), false);
			$data = $this->Sale->find('all', array(  
				'conditions'=> $filters,
				'fields'=>array('Sale.*', 'User.first_name', 'User.last_name'),
				'order'	=> array('Sale.modified'=>'DESC'),
			));  
			
			$all_total_amt = 0;
			$last_key= ''; 
			foreach($data as $key => $p){
			
				$sale_product = $this->SaleProduct->find('all', array(  
					'conditions'=>array('SaleProduct.sale_id'=>$p['Sale']['id'])
				));   
				$total_amt = 0;
				if(!empty($sale_product)) {
					foreach($sale_product as $val) {
						$total_amt +=  $val['SaleProduct']['total_amount']; 
					}
				}  
				
				$postData[$key]['date'] = $p['Sale']['order_date'];
				$postData[$key]['sale_order'] = $p['Sale']['order_no'];
				$postData[$key]['customer_name'] = $p['User']['first_name'] .' '. $p['User']['last_name']; 
				$postData[$key]['reference'] = $p['Sale']['reference']; 
				$postData[$key]['shipment_date'] = $p['Sale']['expected_shipping_date'];
				$postData[$key]['status'] = Configure::read('SalesStatus.' . $p['Sale']['status']); 
				$postData[$key]['amount'] =  number_format($total_amt,2);
				 
				$all_total_amt += $total_amt;  
				
				$last_key += $key;

			}    
			
			if(!empty($postData)){
				//$last_key = $last_key+1;
				$postData[$last_key]['date'] = 'Total';
				$postData[$last_key]['sale_order'] = '';
				$postData[$last_key]['customer_name'] = '';
				$postData[$last_key]['reference'] = '';
				$postData[$last_key]['shipment_data'] = '';
				$postData[$last_key]['status'] = '';
				$postData[$last_key]['amount'] =  number_format($all_total_amt,2);  
			}   
			
			//pr($postData); die; 
			
			$this->Common->createExcelFile($postData,'Excel');
		} 
		
		
		
		public function admin_add() {	
			$this->set('title_for_layout',  __('New Sales Order', true)) ;
			
			if ($this->request->is('post')) {
				//check empty
				if(!empty($this->request->data)){
					if (!isset($this->request->params['data']['_Token']['key']) || ($this->request->params['data']['_Token']['key'] != $this->request->params['_Token']['key'])) {
						$blackHoleCallback = $this->Security->blackHoleCallback;
						$this->$blackHoleCallback();
					}
					
					//validate Sale data
					$this->Sale->set($this->request->data);
					$this->Sale->setValidation('admin');
					if ($this->Sale->validates()) {
						
						$items = (isset($this->request->data['Sale']['p']))?$this->request->data['Sale']['p']:'';
						unset($this->request->data['Sale']['p']);
						//pr($this->request->data); pr($items); die;
						if ($this->Sale->saveAll($this->request->data)) {
							$sale_id = $this->Sale->id; 
							if($items){
								$this->loadModel('SaleProduct');
								foreach($items as $val){
									$sale_products = array();
									$sale_products['SaleProduct']['product_id']		= $val['product_id'];
									$sale_products['SaleProduct']['sale_id']		= $sale_id;
									$sale_products['SaleProduct']['qty']			= $val['quantity'];
									$sale_products['SaleProduct']['rate']			= $val['rate'];
									$sale_products['SaleProduct']['discount']		= $val['discount'];
									$sale_products['SaleProduct']['tax']			= $val['tax'];
									$sale_products['SaleProduct']['total_amount']	= $val['amount'];
									$this->SaleProduct->saveAll($sale_products);
								}
							}
							
							$this->Session->setFlash(__('Sale has been saved successfully.'), 'admin_flash_success');
							$this->redirect(array('action' => 'index'));
							} else {
							$this->Session->setFlash(__('Sale could not be saved. Please try again.'), 'admin_flash_error');
						}
						}else {
						$this->Session->setFlash('Sale could not be saved. Please correct errors.', 'admin_flash_error');
					}
				}
				}else{
				$this->request->data['Sale']['order_date'] = date('Y-m-d');
				$this->request->data['Sale']['order_no'] = "SO-". date('dmy') .'-'. $this->Sale->nextCode();
			}
			
			$users = $this->User->find('list', array('fields'=>array('User.id', 'User.name'), 'conditions'=>array('User.role_id'=>3, 'User.status'=>1), 'order'=>array('User.first_name'=>'ASC')));
			$this->set(compact('users')) ;
		}
		
		
		
		
		public function admin_edit($id = null) {
			$this->set('title_for_layout',  __('Update Sales Information', true)) ;
			$this->Sale->id = $id;
			
			if (!$this->Sale->exists()) {
				throw new NotFoundException(__('Invalid Admin'));
			}
			
			if ($this->request->is('post') || $this->request->is('put')) {	
			
				if(!empty($this->request->data)) {
					if (!isset($this->request->params['data']['_Token']['key']) || ($this->request->params['data']['_Token']['key'] != $this->request->params['_Token']['key'])) {
						$blackHoleCallback = $this->Security->blackHoleCallback;
						$this->$blackHoleCallback();
					}
					
					//validate Sale data
					$this->Sale->set($this->request->data);
					$this->Sale->setValidation('admin');
					if ($this->Sale->validates()){
					
						$items = (isset($this->request->data['Sale']['p']))?$this->request->data['Sale']['p']:'';
						unset($this->request->data['Sale']['p']);
					
						if ($this->Sale->saveAll($this->request->data)) { 
							$sale_id = $id;
							if($items){
								$this->loadModel('SaleProduct');
								$this->SaleProduct->deleteAll(array('SaleProduct.sale_id'=>$id));
								foreach($items as $val){
									$sale_products = array();
									$sale_products['SaleProduct']['product_id']		= $val['product_id'];
									$sale_products['SaleProduct']['sale_id']		= $sale_id;
									$sale_products['SaleProduct']['qty']			= $val['quantity'];
									$sale_products['SaleProduct']['rate']			= $val['rate'];
									$sale_products['SaleProduct']['discount']		= $val['discount'];
									$sale_products['SaleProduct']['tax']			= $val['tax'];
									$sale_products['SaleProduct']['total_amount']	= $val['amount'];
									$this->SaleProduct->saveAll($sale_products);
								}
							} 
							$this->Session->setFlash(__('Sale information has been updated successfully.',true), 'admin_flash_success');
							$this->redirect(array('action'=>'index')) ;
						} else {
							$this->Session->setFlash(__('Sale could not be updated. Please try again.',true), 'admin_flash_error');
						}
					}else {
						$this->Session->setFlash(__('Sale could not be updated. Please correct errors.', true), 'admin_flash_error');
					}
				}	
				}else {		
				$this->Sale->id = $id;
				$this->Sale->bindModel(array('belongsTo'=>array('User')), false);
				$this->request->data = $this->Sale->read(null, $id); 
			}
			
			$users 	= $this->User->find('list', array('fields'=>array('User.id', 'User.name'), 'conditions'=>array('User.role_id'=>3, 'User.status'=>1), 'order'=>array('User.first_name'=>'ASC')));
			$this->set(compact('users')) ;
		}
		
		
		
	    public function admin_delete($id = null){
			$this->Sale->id = $id;
			if (!$this->Sale->exists()) {
				throw new NotFoundException(__('Invalid Sales'));
			}
			
			if (!isset($this->request->params['named']['token']) || ($this->request->params['named']['token'] != $this->request->params['_Token']['key'])) {
				$blackHoleCallback = $this->Security->blackHoleCallback;
				$this->$blackHoleCallback();
			}
			
			$data['Sale']['id'] =  $id;
			$data['Sale']['status'] =  5;
			if ($this->Sale->saveAll($data)) {
				$this->Session->setFlash(__('Sale has been deleted successfully.'), 'admin_flash_success');
				$this->redirect(array('controller' => 'products', 'action' =>'index'));			
				}else{
				$this->Session->setFlash(__('Sale could not be deleted.'), 'admin_flash_error');
				$this->redirect(array('controller' => 'products', 'action' =>'index'));
			}
		}
		
		
		
		public function admin_status($id = null) {
			
			$this->Sale->id = $id;
			if (!$this->Sale->exists()) {
				throw new NotFoundException(__('Invalid Sales'));
			}
			
			if (!isset($this->request->params['named']['token']) || ($this->request->params['named']['token'] != $this->request->params['_Token']['key'])) {
				$blackHoleCallback = $this->Security->blackHoleCallback;
				$this->$blackHoleCallback();
			}
			
			if ($this->Sale->toggleStatus($id)) {
				$this->Session->setFlash(__('Sale  status has been changed.'), 'admin_flash_success');
				$this->redirect($this->referer());
			}
			$this->Session->setFlash(__('Sale status could not be changed.', 'admin_flash_error'));
			$this->redirect($this->referer());
		}
		
		
		
		public function admin_view($id = null) {
			$this->set('title_for_layout',  __('Sales Information', true)) ;
			$result = array();
			
			$this->Sale->id = $id;
			if (!$this->Sale->exists()) {
				throw new NotFoundException(__('Invalid Sales'));
			}
			
			$this->Sale->bindModel(array('belongsTo'=>array('User')), false);
			$this->set('data', $this->Sale->read(null, $id));
		}
		
		
		
		function referer($default = NULL, $local = false){
			$defaultTab = $this->Session->read('Url.defaultTab');
			$Page = $this->Session->read('Url.Page');
			$sort = $this->Session->read('Url.sort');
			$direction = $this->Session->read('Url.direction');
			
			return Router::url(array('action'=>'index', $defaultTab,'Page'=>$Page,'sort'=>$sort,'direction'=>$direction),true);
		}
	}	